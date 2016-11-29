<?php

namespace Features\Milhojas\Domain\Cantine;

use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Milhojas\Infrastructure\Persistence\Cantine\RuleRepository;
use Milhojas\Infrastructure\Persistence\Cantine\TurnRepository;
use Milhojas\Infrastructure\Persistence\Cantine\GroupRepository;
use Milhojas\Infrastructure\Persistence\Cantine\CantineUserInMemoryRepository;
use Milhojas\Domain\Utils\Schedule\MonthWeekSchedule;
use Milhojas\Domain\Utils\Schedule\ListOfDates;
use Milhojas\Domain\School\Student;
use Milhojas\Domain\School\StudentId;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\CantineGroup;
use Milhojas\Domain\Cantine\Rules;
use Milhojas\Domain\Cantine\Assigner;
use Milhojas\Library\ValueObjects\Identity\PersonName;
use org\bovigo\vfs\vfsStream;
use Symfony\Component\Yaml\Yaml;

/**
 * Defines application features from the specific context.
 */
class AdminContext implements SnippetAcceptingContext
{
    private $CantineUserRepository;
    private $rules;
    private $turns;
    private $assigner;
    private $config;
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->CantineUserRepository = new CantineUserInMemoryRepository();
    }

// Given Section

    /**
     * @Given There are some Cantine Users registered
     */
    public function thereAreSomeCantineUsersRegistered(TableNode $table)
    {
        foreach ($table->getHash() as $row) {
            switch ($row['type']) {
                case 'regular':
                    $schedule = $this->buildMonthWeekSchedule($row);
                    break;
                case 'ticket':
                    $date = new \DateTime($row['schedule']);
                    $schedule = new ListOfDates([$date]);
                    break;
                default:
                    // code...
                    break;
            }
            $student = new Student(new StudentId($row['student_id']), new PersonName('Nombre', 'Apellidos'));
            $User = CantineUser::apply($student, $schedule);
            $User->assignToGroup(new CantineGroup($row['group']));
            $this->CantineUserRepository->store($User);
        }
    }

    /**
     * @Given Today is :today
     */
    public function todayIs($today)
    {
        $this->today = new \DateTime($today);
    }

    /**
     * @Given Rules for turn assignation are
     */
    public function rulesForTurnAssignationAre(TableNode $table)
    {
        foreach ($table->getHash() as $row) {
            $this->config['rules'][$row['rule']] = [
                'schedule' => explode(', ', trim($row['schedule'], ' ')),
                'group' => $row['group'],
                'turn' => $row['turn'],
            ];
        }
    }

    /**
     * @Given turns are the following
     */
    public function turnsAreTheFollowing(TableNode $table)
    {
        $this->config['turns'] = $table->getColumn(0);
    }

    /**
     * @Given groups are the following
     */
    public function groupsAreTheFollowing(TableNode $table)
    {
        $this->config['groups'] = $table->getColumn(0);
    }

// When Section

    /**
     * @When Admin asks for the list
     */
    public function adminAsksForTheList()
    {
        $this->List = $this->CantineUserRepository->getUsersForDate($this->today);
    }

// Then Section

    /**
     * @Then the list should contain this Cantine Users
     */
    public function theListShouldContainThisCantineUsers(TableNode $table)
    {
        $expected = [];
        foreach ($table->getHash() as $row) {
            $expected[] = $row['student_id'];
        }
        foreach ($this->List as $User) {
            if (!in_array($User->getStudentId()->getId(), $expected)) {
                throw new \Exception('List is wrong!');
            }
        }
    }

    /**
     * @Then the list should not contain this Cantine Users
     */
    public function theListShouldNotContainThisCantineUsers(TableNode $table)
    {
        $expected = [];
        foreach ($table->getHash() as $row) {
            $expected[] = $row['student_id'];
        }
        foreach ($this->List as $User) {
            if (in_array($User->getStudentId()->getId(), $expected)) {
                throw new \Exception('List is wrong!');
            }
        }
    }

    /**
     * @Then the turns should be assigned as
     */
    public function theTurnsShouldBeAssignedAs(TableNode $table)
    {
        $expected = $table->getHash();

        list($rules, $turns) = $this->getRules();
        $this->assigner = new Assigner($rules);
        $this->assigner->assignUsersForDate($this->List, $this->today);

        foreach ($this->List as $User) {
            foreach ($expected as $row) {
                $turn = $turns->getByName($row['turn']);
                if ($User->getStudentId()->getId() != $row['student_id']) {
                    continue;
                }
                if (!$turn->isAppointed($User)) {
                    throw new \Exception(sprintf('Student %s should be assigned to turn %s', $row['student_id'], $row['turn']));
                }
            }
        }
    }

// Utility methods

    /**
     * Prepare Rules for This context.
     *
     * @return array
     */
    private function getRules()
    {
        $turns = new TurnRepository();
        $turns->load($this->getMockedConfigurationFile());
        $groups = new GroupRepository();
        $groups->load($this->getMockedConfigurationFile());
        $rules = new RuleRepository($turns, $groups);
        $rules->load($this->getMockedConfigurationFile());

        return [$rules, $turns];
    }

    /**
     * Convert a row of table data into a schedule.
     *
     * @param [type] $row [Description]
     *
     * @return MonthWeekSchedule
     */
    private function buildMonthWeekSchedule($row)
    {
        list($month, $weekdays) = explode(': ', $row['schedule']);
        $schedule = [$month => explode(', ', trim($weekdays))];

        return new MonthWeekSchedule($schedule);
    }

    private function getMockedConfigurationFile()
    {
        $this->fileSystem = vfsStream::setUp('root', 0, []);
        $file = vfsStream::newFile('cantine.yml')
            ->withContent(Yaml::dump($this->config))
            ->at($this->fileSystem);

        return $file->url();
    }
}

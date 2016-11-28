<?php

namespace Features\Milhojas\Domain\Cantine;

use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Milhojas\Infrastructure\Persistence\Cantine\CantineUserInMemoryRepository;
use Milhojas\Domain\Utils\Schedule\MonthWeekSchedule;
use Milhojas\Domain\Utils\Schedule\ListOfDates;
use Milhojas\Domain\School\Student;
use Milhojas\Domain\School\StudentId;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\CantineGroup;
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
     * @When Admin asks for the list
     */
    public function adminAsksForTheList()
    {
        $this->List = $this->CantineUserRepository->getUsersForDate($this->today);
    }

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
     * @Given Rules for turn assignation are
     */
    public function rulesForTurnAssignationAre(TableNode $table)
    {
        $this->rules = [];
        foreach ($table->getHash() as $row) {
            $this->rules[$row['rule']] = [
                'schedule' => $row['schedule'],
                'group' => $row['group'],
                'turn' => $row['turn'],
            ];
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
        $this->assigner = new Assigner($this->getMockedConfigurationFile());
        $turns = $this->assigner->generateListFor($this->today, $this->List);
        foreach ($expected as $row) {
            if ($turns[$row['turn']][0]->getStudentId()->getId() !== $row['student_id']) {
                throw new \Exception('Bad turn assignment');
            }
        }
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
        $schedule = [$month => explode(', ', $weekdays)];

        return new MonthWeekSchedule($schedule);
    }

    private function getMockedConfigurationFile()
    {
        $this->fileSystem = vfsStream::setUp('root', 0, []);
        $map = array(
            'turns' => $this->turns,
            'rules' => $this->rules,
        );
        $file = vfsStream::newFile('cantine.yml')
            ->withContent(Yaml::dump($map))
            ->at($this->fileSystem);

        return $file->url();
    }

    /**
     * @Given turns are the following
     */
    public function turnsAreTheFollowing(TableNode $table)
    {
        $this->turns = $table->getColumn(0);
    }
}

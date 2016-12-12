<?php

namespace Features\Milhojas\Domain\Cantine;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\Gherkin\Node\PyStringNode;
use Milhojas\Domain\Cantine\Assigner;
use Milhojas\Domain\Cantine\CantineList;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\CantineGroup;
use Milhojas\Domain\Cantine\CantineConfig;
use Milhojas\Domain\Cantine\CantineUserRepository;
use Milhojas\Domain\Cantine\Factories\RuleFactory;
use Milhojas\Domain\Cantine\Factories\TurnsFactory;
use Milhojas\Domain\Cantine\Factories\GroupsFactory;
use Milhojas\Domain\Cantine\Specification\CantineUserEatingOnDate;
use Milhojas\Domain\Shared\Student;
use Milhojas\Domain\Shared\StudentId;
use Milhojas\Domain\Utils\Schedule\ListOfDates;
use Milhojas\Domain\Utils\Schedule\MonthWeekSchedule;
use Milhojas\Infrastructure\Persistence\Cantine\CantineUserInMemoryRepository;
use Milhojas\Library\EventBus\EventBus;
use Milhojas\LIbrary\ValueObjects\Identity\Person;
use org\bovigo\vfs\vfsStream;
use Prophecy\Prophet;

/**
 * Defines application features from the specific context.
 */
class AdminContext implements Context
{
    /**
     * CantineUser registered.
     *
     * @var CantineUserRepository
     */
    private $CantineUserRepository;
    /**
     * Holds Cantine configuration.
     *
     * @var CantineConfig
     */
    private $cantineConfig;
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
     * @Given Cantine Configuration is
     *
     * @param PyStringNode $string A YAML formatted string
     */
    public function cantineConfigurationIs(PyStringNode $string)
    {
        $this->cantineConfig = new CantineConfig(
            new TurnsFactory(),
            new GroupsFactory(),
            new RuleFactory()
        );
        $this->cantineConfig->load($this->getMockedConfigurationFile($string));
    }

    /**
     * @Given There are some Cantine Users registered
     *
     * @param TableNode $table Students Fixture data
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
            $student = new Student(
                new StudentId($row['student_id']),
                new Person($row['name'], $row['surname'], $row['gender']),
                $row['class'],
                ''
            );
            $User = CantineUser::apply($student, $schedule);
            $User->assignToGroup(new CantineGroup($row['group']));
            $this->CantineUserRepository->store($User);
        }
    }

    /**
     * @Given Today is :today
     *
     * @param string $today a string representation of a date
     */
    public function todayIs($today)
    {
        $this->today = new \DateTime($today);
    }

// When Section

    /**
     * @When Admin asks for the list
     */
    public function adminAsksForTheList()
    {
        $this->List = $this->CantineUserRepository->find(new CantineUserEatingOnDate($this->today));
    }

// Then Section

    /**
     * @Then the turns should be assigned as
     *
     * @param TableNode $table with the example data
     */
    public function theTurnsShouldBeAssignedAs(TableNode $table)
    {
        $prophet = new Prophet();
        $eventBus = $prophet->prophesize(EventBus::class);

        $cantineList = new CantineList($this->today);
        $assigner = new Assigner($this->cantineConfig->getRules(), $eventBus->reveal());
        $assigner->buildList($cantineList, $this->List);
        \PHPUnit_Framework_Assert::assertEquals($table->getHash(), $this->castToResult($cantineList));
    }

// Utility methods

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

    /**
     * Cast CantineList to an array we can compare with expectation.
     *
     * @param CantineList $cantineList we want to cast
     *
     * @return array of CantineListRecord
     */
    private function castToResult(CantineList $cantineList)
    {
        $cantineList->top();
        $result = [];
        while ($cantineList->valid()) {
            $record = $cantineList->current();
            $result[] = [
                'date' => $record->getDate()->format('m/d/Y'),
                'turn' => $record->getTurn()->getName(),
                'student' => $record->getUser()->getPerson()->getListName(),
                'class' => $record->getUser()->getClass(),
                'remarks' => '',
            ];
            $cantineList->next();
        }

        return $result;
    }

    /**
     * Simulates a configuration file with the contents of $string.
     *
     * @param PyStringNode $string
     *
     * @return url for the file
     */
    private function getMockedConfigurationFile(PyStringNode $string)
    {
        $this->fileSystem = vfsStream::setUp('root', 0, []);
        $file = vfsStream::newFile('cantine.yml')
            ->withContent($string->getRaw())
            ->at($this->fileSystem);

        return $file->url();
    }
}

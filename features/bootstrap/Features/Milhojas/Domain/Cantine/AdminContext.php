<?php

namespace Features\Milhojas\Domain\Cantine;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\Gherkin\Node\PyStringNode;
use Milhojas\Domain\Cantine\Factories\RuleFactory;
use Milhojas\Domain\Cantine\Factories\TurnsFactory;
use Milhojas\Domain\Cantine\Factories\GroupsFactory;
use Milhojas\Domain\Cantine\Specification\CantineUserEatingOnDate;
use Milhojas\Domain\Cantine\CantineConfig;
use Milhojas\Domain\Cantine\Assigner;
use Milhojas\Domain\Cantine\CantineGroup;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\CantineList;
use Milhojas\Domain\Utils\Schedule\ListOfDates;
use Milhojas\Domain\Utils\Schedule\MonthWeekSchedule;
use Milhojas\Domain\Common\Student;
use Milhojas\Domain\Common\StudentId;
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
    private $CantineUserRepository;
    private $rules;
    private $turns;
    private $assigner;
    private $config;
    private $eventBus;
    private $prophet;
    private $ticketRepository;
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
        $this->prophet = new Prophet();
        $eventBus = $this->prophet->prophesize(EventBus::class);
        $this->eventBus = $eventBus->reveal();
    }

// Given Section

    /**
     * @Given Cantine Configuration is
     */
    public function cantineConfigurationIs(PyStringNode $string)
    {
        $this->config = $string->getRaw();
        $this->cantineConfig = new CantineConfig(
            new TurnsFactory(),
            new GroupsFactory(),
            new RuleFactory()
        );
        $this->cantineConfig->load($this->getMockedConfigurationFile());
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
     */
    public function theTurnsShouldBeAssignedAs(TableNode $table)
    {
        $this->cantineList = new CantineList($this->today);
        $this->assigner = new Assigner($this->cantineConfig->getRules(), $this->eventBus);
        $this->assigner->buildList($this->cantineList, $this->List);
        $this->shouldGenerateThisTurns($table->getHash());
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
     * Checks if the Assigner generates the right turns.
     *
     * @param array  $expected [Description]
     * @param [type] $builder  [Description]
     */
    private function shouldGenerateThisTurns(array $expected)
    {
        $this->cantineList->top();
        $result = [];
        while ($this->cantineList->valid()) {
            $record = $this->cantineList->current();
            $result[] = [
                'date' => $record->getDate()->format('m/d/Y'),
                'turn' => $record->getTurn()->getName(),
                'student' => $record->getUser()->getPerson()->getListName(),
                'class' => $record->getUser()->getClass(),
                'remarks' => '',
            ];
            $this->cantineList->next();
        }
        \PHPUnit_Framework_Assert::assertEquals($expected, $result);
    }

    private function getMockedConfigurationFile()
    {
        $this->fileSystem = vfsStream::setUp('root', 0, []);
        $file = vfsStream::newFile('cantine.yml')
            ->withContent($this->config)
            ->at($this->fileSystem);

        return $file->url();
    }
}

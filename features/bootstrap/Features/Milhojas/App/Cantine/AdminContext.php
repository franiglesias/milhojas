<?php

namespace Features\Milhojas\App\Cantine;

use Behat\Gherkin\Node\TableNode;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Behat\Context\Context;
use Milhojas\Application\Cantine\Query\GetCantineAttendancesListFor;
use Milhojas\Application\Cantine\Query\GetCantineAttendancesListForHandler;
use Milhojas\Domain\Cantine\CantineGroup;
use Milhojas\Domain\Cantine\CantineList\CantineList;
use Milhojas\Domain\Cantine\CantineConfig;
use Milhojas\Domain\Cantine\CantineUserRepository;
use Milhojas\Domain\Cantine\Factories\RuleFactory;
use Milhojas\Domain\Cantine\Factories\TurnsFactory;
use Milhojas\Domain\Cantine\Factories\GroupsFactory;
use Milhojas\Domain\Cantine\Assigner;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Utils\Schedule\ListOfDates;
use Milhojas\Domain\Shared\Student;
use Milhojas\Domain\Shared\StudentId;
use Milhojas\Domain\Shared\ClassGroup;
use Milhojas\Domain\Utils\Schedule\MonthWeekSchedule;
use Milhojas\Library\QueryBus\Inflector\SymfonyContainerInflector;
use Milhojas\Library\ValueObjects\Identity\Person;
use Milhojas\Infrastructure\Persistence\Cantine\CantineUserInMemoryRepository;
use Milhojas\Library\QueryBus\SimpleQueryBus;
use Milhojas\Library\QueryBus\Loader\TestLoader;
use Milhojas\Library\EventBus\EventBus;
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
        $this->cantineConfig = new CantineConfig(
            new TurnsFactory(),
            new GroupsFactory(),
            new RuleFactory()
        );

        $this->CantineUserRepository = new CantineUserInMemoryRepository();
    }

    /**
     * @Given Cantine Configuration is
     */
    public function cantineConfigurationIs(PyStringNode $string)
    {
        $this->cantineConfig->load($this->getMockedConfigurationFile($string));

        $assigner = new Assigner($this->cantineConfig->getRules(), $this->getEventBus());
        $handler = new GetCantineAttendancesListForHandler($this->CantineUserRepository, $assigner);

        $loader = new TestLoader();
        $loader->add('cantine.get_cantine_attendances_list_for.handler', $handler);

        $inflector = new SymfonyContainerInflector();
        $this->bus = new SimpleQueryBus($loader, $inflector);
    }

    /**
     * Prepares a Mocked EventBus.
     *
     * @return object
     */
    public function getEventBus()
    {
        $prophet = new Prophet();
        $eventBus = $prophet->prophesize(EventBus::class)->reveal();

        return $eventBus;
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
                new ClassGroup($row['class'], $row['class'], 'EP'),
                $row['allergies'].$row['remarks']
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

    /**
     * @When Admin asks for the list
     */
    public function adminAsksForTheList()
    {
        $query = new GetCantineAttendancesListFor($this->today);
        $this->cantineList = $this->bus->execute($query);
    }

    /**
     * @Then the turns should be assigned as
     */
    public function theTurnsShouldBeAssignedAs(TableNode $table)
    {
        \PHPUnit_Framework_Assert::assertEquals($table->getHash(), $this->castToResult($this->cantineList));
    }

    /**
     * Simulates a configuration file with the contents of $string.
     *
     * @param PyStringNode $string
     *
     * @return string url for the virtual file
     */
    private function getMockedConfigurationFile(PyStringNode $string)
    {
        $this->fileSystem = vfsStream::setUp('root', 0, []);
        $file = vfsStream::newFile('cantine.yml')
            ->withContent($string->getRaw())
            ->at($this->fileSystem);

        return $file->url();
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

    /**
     * Cast CantineList to an array we can compare with expectation.
     *
     * @param CantineList $cantineList we want to cast
     *
     * @return array of CantineListUserRecord
     */
    private function castToResult(CantineList $cantineList)
    {
        $cantineList->top();
        $result = [];
        while ($cantineList->valid()) {
            $record = $cantineList->current();
            $result[] = [
                'date' => $record->getDate()->format('m/d/Y'),
                'turn' => $record->getTurnName(),
                'student' => $record->getUserListName(),
                'class' => $record->getClassGroupName(),
                'remarks' => '',
            ];
            $cantineList->next();
        }

        return $result;
    }
}

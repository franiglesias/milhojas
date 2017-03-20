<?php

namespace Features\Milhojas\Domain\Cantine;

use Behat\Gherkin\Node\TableNode;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Behat\Context\Context;
use Milhojas\Application\Cantine\Command\AssignCantineSeats;
use Milhojas\Application\Cantine\Command\AssignCantineSeatsHandler;
use Milhojas\Domain\Cantine\CantineList\SpecialMealsRecord;
use Milhojas\Domain\Cantine\CantineList\TurnStageCantineSeatListReporter;
use Milhojas\Domain\Cantine\CantineList\SpecialMealsCantineSeatListReporter;
use Milhojas\Domain\Cantine\Event\UserWasAssignedToCantineTurn;
use Milhojas\Application\Cantine\Listener\AddUserToCantineList;
use Milhojas\Application\Cantine\Query\GetCantineAttendancesListFor;
use Milhojas\Application\Cantine\Query\GetCantineAttendancesListForHandler;
use Milhojas\Domain\Cantine\CantineGroup;
use Milhojas\Domain\Cantine\CantineList\CantineList;
use Milhojas\Domain\Cantine\CantineUserRepository;
use Milhojas\Domain\Cantine\Assigner;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\Factories\CantineManager;
use Milhojas\Domain\Utils\Schedule\ListOfDates;
use Milhojas\Domain\Shared\Student;
use Milhojas\Domain\Utils\Schedule\MonthWeekSchedule;
use Milhojas\Infrastructure\Persistence\Cantine\CantineSeatInMemoryRepository;
use Milhojas\Messaging\EventBus\EventRecorder;
use Milhojas\Messaging\QueryBus\Worker\QueryWorker;
use Milhojas\Messaging\Shared\Pipeline\WorkerPipeline;
use Milhojas\Messaging\Shared\Inflector\ContainerInflector;
use Milhojas\Infrastructure\Persistence\Cantine\CantineUserInMemoryRepository;
use Milhojas\Messaging\QueryBus\QueryBus;
use Milhojas\Messaging\Shared\Loader\TestLoader;
use Milhojas\Messaging\EventBus\EventBus;
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
    private $CantineSeatRepository;
    private $manager;
    private $recorder;
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
        $this->CantineSeatRepository = new CantineSeatInMemoryRepository();
    }

    /**
     * @Given Cantine Configuration is
     */
    public function cantineConfigurationIs(PyStringNode $string)
    {
        $this->recorder = new EventRecorder();
        $this->manager = new CantineManager($this->getMockedConfigurationFile($string));
        $this->queryBus = $this->buildQueryBus();
    }

    public function buildQueryBus()
    {
        $loader = new TestLoader();
        $loader->add(
            'cantine.get_cantine_attendances_list_for.handler',  new GetCantineAttendancesListForHandler($this->CantineSeatRepository)
        );
        $queryWorker = new QueryWorker($loader, new ContainerInflector());

        return new QueryBus(new WorkerPipeline([$queryWorker]));
    }

    public function applyAssignCantineSeats()
    {
        $assigner = new Assigner($this->manager, $this->recorder);
        $command = new AssignCantineSeats($this->today);
        $handler = new AssignCantineSeatsHandler($assigner, $this->CantineUserRepository);
        $handler->handle($command);
        foreach ($this->recorder as $event) {
            if (get_class($event) == UserWasAssignedToCantineTurn::class) {
                $h = new AddUserToCantineList($this->CantineSeatRepository);
                $h->handle($event);
            }
        }
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
            $User = CantineUser::apply(
                $row['student_id'],
                sprintf('%s, %s', $row['surname'], $row['name']),
                $row['class'],
                substr($row['class'], 0, strpos($row['class'], ' ')),
                $schedule);
            $User->assignToGroup(new CantineGroup($row['group']));

            $allergens = $this->manager->getBlankAllergensSheet();
            if ($row['allergies']) {
                $allergens->check(explode(', ', $row['allergies']));
            }
            $User->setAllergies($allergens);
            $User->setRemarks($row['remarks']);
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
        $this->applyAssignCantineSeats();
        $this->cantineList = $this->queryBus->execute(new GetCantineAttendancesListFor($this->today));
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
     * @return array of CantineSeat
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

    /**
     * @Then statistics should look like this
     */
    public function statisticsShouldLookLikeThis($expected)
    {
        $reporter = new TurnStageCantineSeatListReporter();
        $this->cantineList->accept($reporter);
        \PHPUnit_Framework_Assert::assertEquals($expected, $reporter->getReport());
    }

    /**
     * @Then a list for special meals should look like this
     */
    public function aListForSpecialMealsShouldLookLikeThis($expected)
    {
        $reporter = new SpecialMealsCantineSeatListReporter();
        $this->cantineList->accept($reporter);
        \PHPUnit_Framework_Assert::assertEquals($expected, $reporter->getReport());
    }

// Utility methods

    /**
     * @Transform table:turn,student,special
     */
    public function castToSpecialMealsList(TableNode $table)
    {
        $expected = [];
        foreach ($table->getHash() as $row) {
            $expected[] = new SpecialMealsRecord($row['turn'], $row['student'], $row['special']);
        }

        return $expected;
    }

    /**
     * @Transform table:turn,total,ei,ep,eso,bach
     */
    public function castToStatsData(TableNode $table)
    {
        foreach ($table->getHash() as $row) {
            if ($row['total']) {
                $line['total'] = $row['total'];
            }
            if ($row['ei']) {
                $line['EI'] = $row['ei'];
            }
            if ($row['ep']) {
                $line['EP'] = $row['ep'];
            }
            if ($row['eso']) {
                $line['ESO'] = $row['eso'];
            }
            if ($row['bach']) {
                $line['Bach'] = $row['bach'];
            }
            $expected[$row['turn']] = $line;
        }

        return $expected;
    }
}

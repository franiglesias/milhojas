<?php

namespace Features\Milhojas\Domain\Cantine;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\Gherkin\Node\PyStringNode;
use Milhojas\Domain\Cantine\Assigner;
use Milhojas\Domain\Cantine\CantineList\CantineList;
use Milhojas\Domain\Cantine\CantineList\SpecialMealsRecord;
use Milhojas\Domain\Cantine\CantineList\TurnStageCantineListReporter;
use Milhojas\Domain\Cantine\CantineList\SpecialMealsCantineListReporter;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\CantineGroup;
use Milhojas\Domain\Cantine\CantineUserRepository;
use Milhojas\Domain\Cantine\Factories\CantineManager;
use Milhojas\Domain\Cantine\Specification\CantineUserEatingOnDate;
use Milhojas\Domain\Shared\Student;
use Milhojas\Domain\Shared\StudentId;
use Milhojas\Domain\Shared\ClassGroup;
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
     * @var CantineManager
     */
    private $Manager;
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
        $this->Manager = new CantineManager($this->getMockedConfigurationFile($string));
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

// When Section

    /**
     * @When Admin asks for the list
     */
    public function adminAsksForTheList()
    {
        $this->List = $this->CantineUserRepository->find(new CantineUserEatingOnDate($this->today));
        $prophet = new Prophet();
        $eventBus = $prophet->prophesize(EventBus::class)->reveal();

        $assigner = new Assigner($this->Manager->getRules(), $eventBus);
        $this->cantineList = $assigner->buildList($this->today, $this->List);
    }

// Then Section

    /**
     * @Then the turns should be assigned as
     *
     * @param TableNode $table with the example data
     */
    public function theTurnsShouldBeAssignedAs(TableNode $table)
    {
        \PHPUnit_Framework_Assert::assertEquals($table->getHash(), $this->castToResult($this->cantineList));
    }

    /**
     * @Then statistics should look like this
     */
    public function statisticsShouldLookLikeThis($expected)
    {
        $reporter = new TurnStageCantineListReporter();
        $this->cantineList->accept($reporter);
        \PHPUnit_Framework_Assert::assertEquals($expected, $reporter->getReport());
    }

    /**
     * @Then a list for special meals should look like this
     */
    public function aListForSpecialMealsShouldLookLikeThis($expected)
    {
        $reporter = new SpecialMealsCantineListReporter();
        $this->cantineList->accept($reporter);
        \PHPUnit_Framework_Assert::assertEquals($expected, $reporter->getReport());
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

<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\TableNode;
use Milhojas\Domain\Cantine\TicketCantineUser;
use Milhojas\Domain\Cantine\CantineUserManager;
use Milhojas\Domain\Cantine\RegularCantineUser;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Utils\MonthWeekSchedule;
use Milhojas\Domain\School\StudentId;
use Milhojas\Domain\School\Student;

/**
 * Defines application features from the specific context.
 */
class StudentContext implements SnippetAcceptingContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Transform table:month,weekdays
     */
    public function castScheduleTable(TableNode $scheduleTable)
    {
        $data = array();
        foreach ($scheduleTable->getHash() as $monthHash) {
            $data[$monthHash['month']] = explode(', ', $monthHash['weekdays']);
        }

        return new MonthWeekSchedule($data);
    }

    /**
     * @Given there is a CantineUserManager
     */
    public function thereIsACantineusermanager()
    {
        $this->CantineUserManager = new CantineUserManager();
    }

    /**
     * @Given there is a CantineUserRepository
     */
    public function thereIsACantineuserrepository()
    {
        $this->CantineUserRepository = new CantineUserRepositoryMock();
    }

    /**
     * @Given Student with StudentId :student_id
     */
    public function studentWithStudentid($student_id)
    {
        $this->Student = new Student(new StudentId($student_id));
    }

    /**
     * @Given There is no CantineUser associated to StudentId :arg1
     */
    public function thereIsNoCantineuserAssociatedToStudentid($arg1)
    {
        if ($this->CantineUserRepository->exists($this->Student->getStudentId())) {
            throw new \Exception('A User should not exist for this student');
        }
    }

    /**
     * @When Student with StudentId :arg1 applies to Cantine with schedule
     */
    public function studentWithStudentidAppliesToCantineWithSchedule($arg1, MonthWeekSchedule $schedule)
    {
        $this->User = $this->CantineUserManager->applyAsRegular($this->Student, $schedule);
    }

    /**
     * @Then RegularCantineUser with StudentId :arg1 should be created with schedule
     */
    public function regularcantineuserWithStudentidShouldBeCreatedWithSchedule($arg1, MonthWeekSchedule $schedule)
    {
        \PHPUnit_Framework_Assert::assertInstanceOf(RegularCantineUser::class, $this->User);
        \PHPUnit_Framework_Assert::assertEquals(new StudentId($arg1), $this->User->getStudentId());
    }
    /**
     * @Then RegularCantineUser with StudentId :student_id should be eating on date :date
     */
    public function regularcantineuserWithStudentidShouldBeEatingOnDate($student_id, $date)
    {
        if (!$this->User->isEatingOnDate(new \DateTime($date))) {
            throw new \Exception('Student had a bad schedule');
        }
    }

    /**
     * @Then That CantineUser with StudentId :student_id should be added to CantineUsers Repository
     */
    public function thatCantineuserWithStudentidShouldBeAddedToCantineusersRepository($student_id)
    {
        $this->CantineUserRepository->save($this->User);
        if (!$this->CantineUserRepository->exists(new StudentId($student_id))) {
            throw new Exception('Cantine User was not saved');
        }
    }

    /**
     * @Given there is a CantineUser with StudentId :student_id and schedule
     */
    public function thereIsACantineuserWithStudentidAndSchedule($student_id, MonthWeekSchedule $schedule)
    {
        if (!$this->CantineUserRepository->exists(new StudentId($student_id))) {
            throw new Exception('Cantine User does not exists yet');
        }
    }

    /**
     * @Then RegularCantineUser with StudentId :arg1 should update its schedule to
     */
    public function regularcantineuserWithStudentidShouldUpdateItsScheduleTo($arg1, MonthWeekSchedule $schedule)
    {
        $User = $this->CantineUserRepository->load(new StudentId($arg1));
        $User->updateSchedule($schedule);
        throw new PendingException();
    }

    /**
     * @When Student with StudentId :arg1 applies to Cantine to eat on date :arg2
     */
    public function studentWithStudentidAppliesToCantineToEatOnDate($arg1, $arg2)
    {
        throw new PendingException();
    }

    /**
     * @Then A TicketCantineUser with StudentId :arg1 and date :arg2 should be created
     */
    public function aTicketcantineuserWithStudentidAndDateShouldBeCreated($arg1, $arg2)
    {
        throw new PendingException();
    }

    /**
     * @Then CantineUser with StudentId :arg1 should be added to CantineUsers Repository
     */
    public function cantineuserWithStudentidShouldBeAddedToCantineusersRepository($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given There is a CantineUser with StudentId :arg1 and date :arg2
     */
    public function thereIsACantineuserWithStudentidAndDate($arg1, $arg2)
    {
        throw new PendingException();
    }

    /**
     * @Then TicketCantineUser with StudentId :arg1 should update its dates
     */
    public function ticketcantineuserWithStudentidShouldUpdateItsDates($arg1, MonthWeekSchedule $schedule)
    {
        throw new PendingException();
    }

    /**
     * @Then Student with StudentId :arg1 should be eating on date :arg2
     */
    public function studentWithStudentidShouldBeEatingOnDate($arg1, $arg2)
    {
        throw new PendingException();
    }

    /**
     * @Then Student with StudentId :arg1 should be eating on dates
     */
    public function studentWithStudentidShouldBeEatingOnDates($arg1, TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @Then Student with Student :arg1 should not be eating on date :arg2
     */
    public function studentWithStudentShouldNotBeEatingOnDate($arg1, $arg2)
    {
        throw new PendingException();
    }
}

class CantineUserRepositoryMock
{
    private $users;

    public function __construct()
    {
        $this->users = [
            'student-02' => new RegularCantineUser(new StudentId('student-02'), new MonthWeekSchedule(array(
                'october' => ['monday', 'tuesday'],
                'november' => ['monday', 'wednesday', 'friday'],
            ))),
            'student-04' => new TicketCantineUser(new StudentId('student-03'), '11-15-2016'),
        ];
    }

    public function exists($id)
    {
        return isset($this->users[$id->getId()]);
    }

    public function save(CantineUser $user)
    {
        $id = $user->getStudentId()->getId();
        $this->users[$id] = $user;
    }
}

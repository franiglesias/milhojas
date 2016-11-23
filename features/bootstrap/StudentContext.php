<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\TableNode;
use Milhojas\Domain\School\Student;
use Milhojas\Domain\School\StudentId;
use Milhojas\Domain\Utils\Schedule;
use Milhojas\Domain\Utils\MonthWeekSchedule;
use Milhojas\Domain\Utils\RandomDaysSchedule;
use Milhojas\Domain\Cantine\CantineUserRepository;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\CantineGroup;
use Milhojas\Infrastructure\Persistence\Cantine\CantineUserInMemoryRepository;

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
        $this->CantineUserRepository = new CantineUserInMemoryRepository();
        $this->CantineUserRepository->store(CantineUser::apply(
            new Student(new StudentId('student-02')),
            new MonthWeekSchedule([
                    'october' => ['monday', 'tuesday'],
                    'november' => ['monday', 'wednesday', 'friday'],
                ])
            ));
        $this->CantineUserRepository->store(CantineUser::apply(
            new Student(new StudentId('student-04')),
            new RandomDaysSchedule([new \DateTime('11/15/2016')])
            ));
    }

    /**
     * @Given Student with StudentId :student_id
     */
    public function studentWithStudentid($student_id)
    {
        $this->Student = new Student(new StudentId($student_id));
    }

    /**
     * @Given There is no CantineUser associated to it
     */
    public function thereIsNoCantineuserAssociatedToIt()
    {
        $this->User = $this->CantineUserRepository->retrieve($this->Student->getStudentId());
        if (!is_null($this->User)) {
            throw new \Exception('There is a previous user, and should not!');
        }
    }

    /**
     * @When Student applies to Cantine with schedule
     */
    public function studentAppliesToCantineWithSchedule(Schedule $schedule)
    {
        $this->User = CantineUser::apply($this->Student, $schedule);
    }

    /**
     * @When Student applies to Cantine with a ticket to eat on date :date
     */
    public function studentAppliesToCantineWithATicketToEatOnDate($date)
    {
        $this->User = CantineUser::apply($this->Student, new RandomDaysSchedule([$date]));
    }

    /**
     * @Then Student should be registered as Cantine User
     */
    public function studentShouldBeRegisteredAsCantineUser()
    {
        $this->CantineUserRepository->store($this->User);
    }

    /**
     * @Then Student should be eating on date :date
     */
    public function studentShouldBeEatingOnDate($date)
    {
        if (!$this->User->isEatingOnDate($date)) {
            throw new \Exception('Student should be eating on date, but not.');
        }
    }

    /**
     * @Given There is a CantineUser associated and previous schedule
     */
    public function thereIsACantineuserAssociatedAndPreviousSchedule(Schedule $schedule)
    {
        $this->User = $this->CantineUserRepository->retrieve($this->Student->getStudentId());
        if (!$this->User) {
            throw new \Exception('There is no User with id: '.$this->Student->getStudentId());
        }
    }

    /**
     * @When Student modifies its schedule with
     */
    public function studentModifiesItsScheduleWith(Schedule $schedule)
    {
        $this->User->updateSchedule($schedule);
    }

    /**
     * @When Student buys a ticket to eat on date :date
     */
    public function studentBuysATicketToEatOnDate($date)
    {
        $this->User->updateSchedule(new RandomDaysSchedule([$date]));
    }

    /**
     * @Then Student should not be eating on dates
     */
    public function studentShouldNotBeEatingOnDates(TableNode $dates)
    {
        foreach ($dates->getHash() as $row) {
            if ($this->User->isEatingOnDate(new \DateTime($row['dates']))) {
                throw new \Exception(sprintf('Student should NOT be eating on date %s, but not.', $row['dates']));
            }
        }
    }

    /**
     * @Given There is a CantineUser associated and has a prior ticket for date :arg1
     */
    public function thereIsACantineuserAssociatedAndHasAPriorTicketForDate($arg1)
    {
        $this->User = $this->CantineUserRepository->retrieve($this->Student->getStudentId());
    }

    /**
     * @Then Student should be eating on dates
     */
    public function studentShouldBeEatingOnDates(TableNode $dates)
    {
        foreach ($dates->getHash() as $row) {
            if (!$this->User->isEatingOnDate(new \DateTime($row['dates']))) {
                throw new \Exception(sprintf('Student should be eating on date %s, but not.', $row['dates']));
            }
        }
    }

    /**
     * @Transform table:month,weekdays
     */
    public function castToSchedule(TableNode $scheduleTable)
    {
        $schedule = array();
        foreach ($scheduleTable->getHash() as $month) {
            $schedule[$month['month']] = explode(', ', $month['weekdays']);
        }

        return new MonthWeekSchedule($schedule);
    }

    /**
     * @Transform :date
     */
    public function castToDate($date)
    {
        return new \DateTime($date);
    }

    /**
     * @Then Student should be assigned to a CantineGroup
     */
    public function studentShouldBeassignToGroupACantinegroup()
    {
        $this->User->assignToGroup(new CantineGroup('Test group'));
    }
}

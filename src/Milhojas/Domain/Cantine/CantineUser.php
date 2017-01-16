<?php

namespace Milhojas\Domain\Cantine;

use League\Period\Period;
use Milhojas\Domain\Cantine\Exception\InvalidTicket;
use Milhojas\Domain\Shared\Student;
use Milhojas\Domain\Shared\StudentId;
use Milhojas\Domain\Utils\Schedule\Schedule;
use Milhojas\Domain\Utils\Schedule\NullSchedule;
use Milhojas\Domain\Utils\Schedule\ListOfDates;
use Milhojas\Library\Sortable\Sortable;
use Milhojas\LIbrary\ValueObjects\Identity\Person;

/**
 * Represents a CantineUser.
 */
class CantineUser implements Sortable
{
    protected $studentId;
    protected $person;
    protected $schedule;
    protected $allergens;
    protected $cantineGroup;
    protected $classGroup;
    protected $remarks;

    public function __construct(Student $student, Schedule $schedule)
    {
        $this->studentId = $student->getId();
        $this->schedule = $schedule;
        $this->person = $student->getPerson();
        $this->allergens = $student->getAllergies();
        $this->cantineGroup = new NullCantineGroup();
        $this->classGroup = $student->getClass();
        $this->remarks = $student->getRemarks();
    }

    /**
     * Student applies to Cantine Service.
     *
     * @param Student       $student
     * @param Schedule|null $schedule
     */
    public static function apply(Student $student, Schedule $schedule = null)
    {
        $schedule = $schedule ? $schedule : new NullSchedule();
        $cantineUser = new self($student, $schedule);

        return $cantineUser;
    }
    /**
     * Tells if the User is expected to use the cantine on date provided.
     *
     * @param \DateTimeInterface $date
     *
     * @return bool
     */
    public function isEatingOnDate(\DateTimeInterface $date)
    {
        return $this->schedule->isScheduledDate($date);
    }
    /**
     * Tells what Student is associate to this CantineUser.
     *
     * @return StudentId And object that identifies the student associated with this CantineUser
     */
    public function getStudentId()
    {
        return $this->studentId;
    }

    /**
     * Updates the schedule merging data with another schedule.
     *
     * @param Schedule $delta
     */
    public function updateSchedule(Schedule $delta)
    {
        $this->schedule = $this->schedule->update($delta);
    }

    public function isEnrolled()
    {
        return true;
    }

    /**
     * Tells if Use belongs to a $cantineGroup.
     *
     * @param CantineGroup $cantineGroup
     *
     * @return bool true if the User belongs
     */
    public function belongsToGroup(CantineGroup $cantineGroup)
    {
        return $this->cantineGroup->isTheSameAs($cantineGroup);
    }

    /**
     * Assigns this user to the $cantineGroup.
     *
     * @param CantineGroup $cantineGroup
     */
    public function assignToGroup(CantineGroup $cantineGroup)
    {
        $this->cantineGroup = $cantineGroup;
    }

    /**
     * {@inheritdoc}
     */
    public function compare($anotherUser)
    {
        return $this->person->compare($anotherUser->getPerson());
    }

    /**
     * Uaser buys ticket(s) for one or several dates.
     *
     * @param ListOfDates $dates
     */
    public function buysTicketFor(ListOfDates $dates)
    {
        foreach ($dates as $date) {
            if ($this->isEatingOnDate($date)) {
                throw new InvalidTicket('Trying to buy a ticket for a previously scheduled date.');
            }
        }
        $this->schedule->chain($dates);
    }

    /**
     * Tells the user person.
     *
     * @return Person the User Name
     */
    public function getPerson()
    {
        return $this->person;
    }

    public function getClass()
    {
        return $this->classGroup;
    }

    public function isAllergic()
    {
        return $this->allergens->isAllergic();
    }

    public function getAllergens()
    {
        return $this->allergens;
    }

    public function isBillableOn(Period $month)
    {
        return $this->schedule->scheduledDays($month) > 0;
    }

    public function getBillableDaysOn(Period $month)
    {
        return $this->schedule->scheduledDays($month);
    }

    public function getListName()
    {
        return $this->person->getListName();
    }

    public function getClassGroupName()
    {
        return $this->classGroup->getShortName();
    }

    public function getStageName()
    {
        return $this->classGroup->getStageName();
    }

    public function getRemarks()
    {
        return $this->remarks;
    }
}

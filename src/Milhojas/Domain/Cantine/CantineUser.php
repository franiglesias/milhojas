<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\Exception\InvalidTicket;
use Milhojas\Domain\Common\Student;
use Milhojas\Domain\Utils\Schedule\Schedule;
use Milhojas\Domain\Utils\Schedule\NullSchedule;
use Milhojas\Domain\Utils\Schedule\ListOfDates;
use Milhojas\Library\Sortable\Sortable;
use Milhojas\Library\ValueObjects\Identity\PersonName;

/**
 * Represents a CantineUser.
 */
class CantineUser implements Sortable
{
    protected $studentId;
    protected $allergens;
    protected $schedule;
    protected $group;
    protected $name;

    public function __construct(Student $student, Schedule $schedule)
    {
        $this->studentId = $student->getId();
        $this->schedule = $schedule;
        $this->name = $student->getName();
        $this->allergens = $student->getAllergies();
        $this->group = new NullCantineGroup();
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
     * @param \DateTime $date
     *
     * @return bool
     */
    public function isEatingOnDate(\DateTime $date)
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
     * Tells if Use belongs to a $group.
     *
     * @param CantineGroup $group
     *
     * @return bool true if the User belongs
     */
    public function belongsToGroup(CantineGroup $group)
    {
        return $this->group->isTheSameAs($group);
    }

    /**
     * Assigns this user to the $group.
     *
     * @param CantineGroup $group
     */
    public function assignToGroup(CantineGroup $group)
    {
        $this->group = $group;
    }

    /**
     * {@inheritdoc}
     */
    public function compare($anotherUser)
    {
        return $this->name->compare($anotherUser->getName());
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
        $this->schedule->setNext($dates);
    }

    /**
     * Tells the user name.
     *
     * @return PersonName the User Name
     */
    public function getName()
    {
        return $this->name;
    }

    public function isAllergic()
    {
        return $this->allergens->isAllergic();
    }

    public function getAllergens()
    {
        return $this->allergens;
    }
}

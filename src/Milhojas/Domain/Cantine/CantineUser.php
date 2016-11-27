<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Domain\School\Student;
use Milhojas\Domain\School\StudentId;
use Milhojas\Domain\Utils\Schedule;
use Milhojas\Domain\Utils\NullSchedule;
use Milhojas\Domain\Utils\ListOfDates;
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

    public function __construct(StudentId $studentId, PersonName $name, Schedule $schedule)
    {
        $this->studentId = $studentId;
        $this->schedule = $schedule;
        $this->name = $name;
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
        $cantineUser = new self($student->getStudentId(), $student->getName(), $schedule);

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

    public function updateAllergiesInformation($argument1)
    {
        // TODO: write logic here
    }

    public function compare($anotherUser)
    {
        return $this->name->compare($anotherUser->name);
    }

    public function buysTicketFor(ListOfDates $dates)
    {
        $this->schedule = $this->schedule->update($dates);
    }
}

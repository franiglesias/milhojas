<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Domain\School\Student;
use Milhojas\Domain\School\StudentId;
use Milhojas\Domain\Utils\Schedule;

/**
 * Represents a CantineUser.
 */
class CantineUser
{
    protected $studentId;
    protected $allergens;
    protected $schedule;
    protected $group;

    public function __construct(Student $student, Schedule $schedule, CantineGroupMapper $mapper)
    {
        $this->studentId = $student->getStudentId();
        $this->schedule = $schedule;
        $this->group = $mapper->getGroupForStudent($student);
    }

    public static function apply(Student $student, Schedule $schedule, CantineGroupMapper $mapper)
    {
        $cantineUser = new self($student, $schedule, $mapper);

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

    public function updateAllergiesInformation($argument1)
    {
        // TODO: write logic here
    }

    public function isEnrolled()
    {
        return true;
    }

    public function belongsToGroup(CantineGroup $group)
    {
        return $this->group == $group;
    }
}

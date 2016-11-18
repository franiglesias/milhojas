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

    public function __construct(Student $student, Schedule $schedule)
    {
        $this->studentId = $student->getStudentId();
        $this->schedule = $schedule;
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
        $this->schedule->isScheduledDate($date);
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

    public function setAllergies($allergens)
    {
        $this->allergens = $allergens;
    }

    public function allergicTo()
    {
        return $this->allergens;
    }
}

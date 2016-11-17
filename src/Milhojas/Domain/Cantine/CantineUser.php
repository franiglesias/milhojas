<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Domain\School\StudentId;

/**
 * Interface to represent a CantineUser.
 */
abstract class CantineUser
{
    protected $studentId;
    protected $allergens;

    public function __construct(StudentId $student_id)
    {
        $this->studentId = $student_id;
    }
    /**
     * Tells if the User is expected to use the cantine on date provided.
     *
     * @param \DateTime $date
     *
     * @return bool
     */
    abstract public function isEatingOnDate(\DateTime $date);
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

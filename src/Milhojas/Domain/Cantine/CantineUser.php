<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Domain\School\StudentId;


/**
 * Interface to represent a CantineUser.
 */
interface CantineUser
{
    /**
     * Tells if the User is expected to use the cantine on date provided.
     *
     * @param \DateTime $date
     *
     * @return bool
     */
    public function isEatingOnDate(\DateTime $date);
    /**
     * Tells what Student is associate to this CantineUser.
     *
     * @return StudentId And object that identifies the student associated with this CantineUser
     */
    public function getStudentId();
}

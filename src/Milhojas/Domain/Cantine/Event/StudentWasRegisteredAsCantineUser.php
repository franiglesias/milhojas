<?php

namespace Milhojas\Domain\Cantine\Event;

use Milhojas\Messaging\EventBus\Event;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\School\Student;

/**
 * Notifies to Listener that a Student Was Registered as Cantine User.
 */
class StudentWasRegisteredAsCantineUser implements Event
{
    private $student;
    private $cantineUser;

    public function __construct(Student $student, CantineUser $cantineUser)
    {
        $this->student = $student;
        $this->cantineUser = $cantineUser;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'cantine.student_was_registered_as_cantine_user.event';
    }

    public function getStudent()
    {
        return $this->student;
    }

    public function getCantineUser()
    {
        return $this->cantineUser;
    }
}

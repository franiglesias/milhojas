<?php

namespace Milhojas\Domain\Cantine\Event;

use Milhojas\Library\EventBus\Event;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\School\Student;

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
        return 'milhojas.cantine.student_was_registered_as_cantine_user';
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

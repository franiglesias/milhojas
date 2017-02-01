<?php

namespace Milhojas\Domain\Shared\Event;

use Milhojas\Messaging\EventBus\Event;

class StudentWasEnrolled implements Event
{
    public function getName()
    {
        return 'shared.student_was_enrolled.event';
    }
}

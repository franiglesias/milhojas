<?php

namespace Milhojas\Library\Messaging\EventBus;

/**
 * Represents a declarative message about something that had happened in the app domain.
 */
interface Event
{
    /**
     * The name that identifies this event.
     *
     * @return string a name context.event
     */
    public function getName();
}

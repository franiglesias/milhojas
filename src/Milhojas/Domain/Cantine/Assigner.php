<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\Event\UserWasAssignedToCantineTurn;
use Milhojas\Domain\Cantine\Event\UserWasNotAssignedToCantineTurn;
use Milhojas\Domain\Cantine\Event\CantineSeatsHasBeenAssigned;
use Milhojas\Domain\Cantine\Exception\CantineUserCouldNotBeAssignedToTurn;
use Milhojas\Domain\Cantine\Factories\CantineManager;
use Milhojas\Library\Messaging\EventBus\EventRecorder;

/**
 * Assigns Users to their Cantine Turns.
 */
class Assigner
{
    private $manager;
    private $eventBus;

    public function __construct(CantineManager $manager, EventRecorder $eventRecorder)
    {
        $this->manager = $manager;
        $this->eventRecorder = $eventRecorder;
    }

    public function assign(\DateTimeInterface $date, $users)
    {
        $rules = $this->manager->getRules();
        foreach ($users as $user) {
            try {
                $turn = $rules->assignsUserToTurn($user, $date);
                $this->eventRecorder->recordThat(new UserWasAssignedToCantineTurn($user, $turn, $date));
            } catch (CantineUserCouldNotBeAssignedToTurn $e) {
                $this->eventRecorder->recordThat(new UserWasNotAssignedToCantineTurn($user, $date));
            }
        }
        $this->eventRecorder->recordThat(new CantineSeatsHasBeenAssigned($date));
    }
}

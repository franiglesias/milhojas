<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\CantineList\CantineList;
use Milhojas\Domain\Cantine\CantineList\CantineListUserRecord;
use Milhojas\Domain\Cantine\Event\UserWasAssignedToCantineTurn;
use Milhojas\Domain\Cantine\Event\UserWasNotAssignedToCantineTurn;
use Milhojas\Domain\Cantine\Event\CantineSeatsHasBeenAssigned;
use Milhojas\Domain\Cantine\Exception\CantineUserCouldNotBeAssignedToTurn;
use Milhojas\Domain\Cantine\Factories\CantineManager;
use Milhojas\Library\Messaging\EventBus\EventBus;

/**
 * Assigns Users to their Cantine Turns.
 */
class Assigner
{
    private $manager;
    private $eventBus;

    public function __construct(CantineManager $manager, EventBus $eventBus)
    {
        $this->manager = $manager;
        $this->eventBus = $eventBus;
    }

    public function buildList(\DateTimeInterface $date, $users)
    {
        $rules = $this->manager->getRules();
        $cantineList = new CantineList();
        foreach ($users as $user) {
            try {
                $turn = $rules->assignsUserToTurn($user, $date);
                $cantineList->insert(CantineListUserRecord::createFromUserTurnAndDate($user, $turn, $date));
                $this->eventBus->dispatch(new UserWasAssignedToCantineTurn($user, $turn, $date));
            } catch (CantineUserCouldNotBeAssignedToTurn $e) {
                $this->eventBus->dispatch(new UserWasNotAssignedToCantineTurn($user, $date));
            }
        }
        $this->eventBus->dispatch(new CantineSeatsHasBeenAssigned($date, $cantineList));

        return $cantineList;
    }
}

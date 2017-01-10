<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\CantineList\CantineList;
use Milhojas\Domain\Cantine\CantineList\CantineListUserRecord;
use Milhojas\Application\Cantine\Event\UserWasAssignedToCantineTurn;
use Milhojas\Application\Cantine\Event\UserWasNotAssignedToCantineTurn;
use Milhojas\Domain\Cantine\Exception\CantineUserCouldNotBeAssignedToTurn;
use Milhojas\Library\EventBus\EventBus;

/**
 * Assigns Users to their Cantine Turns.
 */
class Assigner
{
    private $ruleChain;
    private $eventBus;

    public function __construct(Rule $ruleChain, EventBus $eventBus)
    {
        $this->ruleChain = $ruleChain;
        $this->eventBus = $eventBus;
    }

    public function buildList(\DateTimeInterface $date, $users)
    {
        $list = new CantineList($date);
        foreach ($users as $user) {
            try {
                $turn = $this->ruleChain->assignsUserToTurn($user, $list->getDate());
                $list->insert(new CantineListUserRecord($date, $turn, $user));
                $this->eventBus->dispatch(new UserWasAssignedToCantineTurn($user, $turn, $date));
            } catch (CantineUserCouldNotBeAssignedToTurn $e) {
                $this->eventBus->dispatch(new UserWasNotAssignedToCantineTurn($user, $date));
            }
        }

        return $list;
    }
}

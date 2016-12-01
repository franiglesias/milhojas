<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Application\Cantine\Event\UserWasAssignedToCantineTurn;
use Milhojas\Application\Cantine\Event\UserWasNotAssignedToCantineTurn;
use Milhojas\Library\EventBus\EventBus;

class Assigner
{
    private $ruleChain;
    private $eventBus;

    public function __construct(Rule $ruleChain, EventBus $eventBus)
    {
        $this->ruleChain = $ruleChain;
        $this->eventBus = $eventBus;
    }

    public function assignUsersForDate($users, \DateTime $date)
    {
        foreach ($users as $user) {
            $turn = $this->ruleChain->assignsUserToTurn($user, $date);
            if (!$turn) {
                $this->eventBus->handle(new UserWasNotAssignedToCantineTurn($user, $date));
                continue;
            }
            $this->eventBus->handle(new UserWasAssignedToCantineTurn($user, $turn, $date));
        }
    }
}

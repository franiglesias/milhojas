<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Application\Cantine\Event\UserWasAssignedToCantineTurn;
use Milhojas\Application\Cantine\Event\UserWasNotAssignedToCantineTurn;
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

    /**
     * Runs the User list through the rules chain to assign users to their turns.
     *
     * Dispatches UserWasAssignedToCantineTurn | UserWasNotAssignedToCantineTurn
     *
     * @param array     $users CantineUser
     * @param \DateTime $date
     */
    public function assignUsersForDate($users, \DateTime $date)
    {
        foreach ($users as $user) {
            $turn = $this->ruleChain->assignsUserToTurn($user, $date);
            if (!$turn) {
                $this->eventBus->dispatch(new UserWasNotAssignedToCantineTurn($user, $date));
                continue;
            }
            $this->eventBus->dispatch(new UserWasAssignedToCantineTurn($user, $turn, $date));
        }
    }
}

<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Domain\Utils\Schedule\WeeklySchedule;

class TurnRule
{
    private $schedule;
    private $turn;
    private $next;

    public function __construct(
        $turn,
        WeeklySchedule $schedule,
        CantineGroup $group,
        $enrolled,
        $notEnrolled
        ) {
        $this->turn = $turn;
        $this->schedule = $schedule;
        $this->group = $group;
        $this->enrolled = $enrolled;
        $this->noEnrolled = $notEnrolled;
        $this->next = null;
    }

    /**
     * Assigns a User to a turn on a given data taking care of different conditions
     * Delegates the assignment to a chained rule. If there are no more rules it return null.
     *
     * @param CantineUser $User
     * @param \DateTime   $date
     *
     * @return int The turn
     */
    public function getAssignedTurn(CantineUser $User, \DateTime $date)
    {
        if (!$this->isApplicableOnThisDate($date)) {
            return $this->delegate($User, $date);
        }

        if (!$this->isApplicableToTheGroupOfTheUser($User)) {
            return $this->delegate($User, $date);
        }

        return $this->turn;
    }

    /**
     * Chains the next rule that should try to assign the turn.
     *
     * @param TurnRule $delegateTo
     */
    public function chain(TurnRule $delegateTo)
    {
        if (!$this->next) {
            $this->next = $delegateTo;

            return;
        }
        $this->next->chain($delegateTo);
    }

    /**
     * Rule can be applied to the Group to which the User belongs.
     *
     * @param CantineUser $User [Description]
     *
     * @return bool
     */
    private function isApplicableToTheGroupOfTheUser(CantineUser $User)
    {
        return $User->belongsToGroup($this->group);
    }
    /**
     * Rule can be applied on this date givenits schedule.
     *
     * @param \DateTime $date [Description]
     *
     * @return bool
     */
    private function isApplicableOnThisDate(\DateTime $date)
    {
        return $this->schedule->isScheduledDate($date);
    }

    private function delegate(CantineUser $User, \DateTime $date)
    {
        if (!$this->next) {
            return null;
        }

        return $this->next->getAssignedTurn($User, $date);
    }
}

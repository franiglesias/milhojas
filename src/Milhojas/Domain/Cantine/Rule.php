<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Domain\Utils\Schedule\WeeklySchedule;

class Rule
{
    private $schedule;
    private $turn;
    private $next;

    public function __construct(
        Turn $turn,
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

    public function assignsUserToTurn(CantineUser $User, \DateTime $date)
    {
        if (!$this->isApplicableOnThisDate($date)) {
            return $this->delegate($User, $date);
        }

        if (!$this->isApplicableToTheGroupOfTheUser($User)) {
            return $this->delegate($User, $date);
        }

        $this->turn->appoint($User);
    }
    /**
     * Chains the next rule that should try to assign the turn.
     *
     * @param Rule $delegateTo
     */
    public function chain(Rule $delegateTo)
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

        $this->next->assignsUserToTurn($User, $date);
    }
}

<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Domain\Utils\WeeklySchedule;

class TurnRule
{
    private $schedule;
    private $turn;

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
    }

    public function getAssignedTurn(CantineUser $User, \DateTime $date)
    {
        if (!$this->isApplicableOnThisDate($date)) {
            return null;
        }

        if (!$this->isApplicableToTheGroupOfTheUser($User)) {
            return null;
        }

        return $this->turn;
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
}

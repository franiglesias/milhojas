<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Domain\Utils\Schedule\WeeklySchedule;

/**
 * Represents a rule for turn assignation in the CantineService
 * If rule is applicable and conditions are met, the User is assigned to a Turn.
 */
class Rule
{
    /**
     * Weekly Schedule in which this rule can be applied.
     *
     * @var WeeklySchedule
     */
    private $schedule;
    /**
     * The Cantine Turn that this rule will assign.
     *
     * @var Turn
     */
    private $turn;

    /**
     * The rule to delegate is current instance can assing a user.
     *
     * @var Rule
     */
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

    /**
     * If the rule applies and all conditions are met the User is assigned to the Turn on date specified.
     *
     * @param CantineUser $User
     * @param \DateTime   $date
     *
     * @return bool true if uesr was assigned
     */
    public function assignsUserToTurn(CantineUser $User, \DateTime $date)
    {
        if (!$this->isApplicable($date, $User)) {
            return $this->delegate($User, $date);
        }

        return $this->turn;
    }

    /**
     * Evaluates if all conditions are met to assign user to the Turn.
     *
     * @param \DateTime   $date
     * @param CantineUser $User
     *
     * @return bool true if all conditions are met
     */
    public function isApplicable(\DateTime $date, CantineUser $User)
    {
        return $this->isApplicableOnThisDate($date)
            && $this->isApplicableToTheGroupOfTheUser($User);
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
            return false;
        }

        return $this->next->assignsUserToTurn($User, $date);
    }
}

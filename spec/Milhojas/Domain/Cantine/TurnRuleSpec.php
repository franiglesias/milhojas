<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\Turn;
use Milhojas\Domain\Cantine\TurnRule;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\CantineGroup;
use Milhojas\Domain\Utils\Schedule\WeeklySchedule;
use PhpSpec\ObjectBehavior;

class TurnRuleSpec extends ObjectBehavior
{
    public function let(
        WeeklySchedule $schedule,
        CantineGroup $group,
        CantineUser $User,
        Turn $turn)
    {
        $User->belongsToGroup($group)->willReturn(true);
        $User->isEnrolled()->willReturn(false);

        $this->beConstructedWith($turn, $schedule, $group, [], []);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(TurnRule::class);
    }
    public function it_assigns_turn(
        $User,
        $group,
        \DateTime $date,
        $schedule,
        $turn)
    {
        $schedule->isScheduledDate($date)->willReturn(true);
        $this->getAssignedTurn($User, $date)->shouldBe($turn);
    }

    public function it_appoints_user_in_turn(
        $User,
        $turn,
        $group,
        \DateTime $date,
        $schedule)
    {
        $schedule->isScheduledDate($date)->willReturn(true);
        $turn->appoint($User)->shouldBeCalled();
        $this->assignsUserToTurn($User, $date);
    }

    public function it_delegates_to_another_rule_if_it_cant_handle_conditions(
        $User,
        $group,
        \DateTime $date,
        $schedule,
        WeeklySchedule $schedule2,
        Turn $turn2)
    {
        $schedule->isScheduledDate($date)->willReturn(false);

        $delegated = $this->getDelegatedRule($turn2, true, $schedule2, $date, $group);
        $this->chain($delegated);

        $this->getAssignedTurn($User, $date)->shouldBe($turn2);
    }

    public function it_can_manage_three_or_more_chained_rules(
        $User,
        $group,
        \DateTime $date,
        $schedule,
        WeeklySchedule $schedule2,
        WeeklySchedule $schedule3,
        Turn $turn2,
        Turn $turn3
        ) {
        $schedule->isScheduledDate($date)->willReturn(false);

        $delegated = $this->getDelegatedRule($turn2, false, $schedule2, $date, $group);
        $this->chain($delegated);

        $lastDelegated = $this->getDelegatedRule($turn3, true, $schedule3, $date, $group);
        $this->chain($lastDelegated);

        $this->getAssignedTurn($User, $date)->shouldBe($turn3);
    }

    public function it_returns_first_positive(CantineUser $User, $group, \DateTime $date, $schedule, WeeklySchedule $schedule2, $turn, Turn $turn2)
    {
        $schedule->isScheduledDate($date)->willReturn(true);

        $delegated = $this->getDelegatedRule($turn2, true, $schedule2, $date, $group);
        $this->chain($delegated);

        $this->getAssignedTurn($User, $date)->shouldBe($turn);
    }

    private function getDelegatedRule(Turn $turn, $result, WeeklySchedule $schedule2, \DateTime $date, $group)
    {
        $schedule2->isScheduledDate($date)->willReturn($result);
        $delegated = new TurnRule($turn->getWrappedObject(), $schedule2->getWrappedObject(), $group->getWrappedObject(), [], []);

        return $delegated;
    }
}

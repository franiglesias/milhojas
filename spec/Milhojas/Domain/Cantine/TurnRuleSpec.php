<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\TurnRule;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\CantineGroup;
use Milhojas\Domain\Utils\WeeklySchedule;
use PhpSpec\ObjectBehavior;

class TurnRuleSpec extends ObjectBehavior
{
    public function let(CantineUser $User, WeeklySchedule $schedule, CantineGroup $group, $enrolled, $notEnrolled)
    {
        $User->belongsToGroup($group)->willReturn(true);
        $User->isEnrolled()->willReturn(false);

        $this->beConstructedWith(1, $schedule, $group, [], []);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(TurnRule::class);
    }
    public function it_assigns_turn(CantineUser $User, $group, \DateTime $date, $schedule)
    {
        $schedule->isScheduledDate($date)->willReturn(true);
        $this->getAssignedTurn($User, $date)->shouldBe(1);
    }

    public function it_delegates_to_another_rule_if_it_cant_handle_conditions(CantineUser $User, $group, \DateTime $date, $schedule, WeeklySchedule $altSchedule)
    {
        $schedule->isScheduledDate($date)->willReturn(false);

        $delegated = $this->getDelegatedRule(2, true, $altSchedule, $date, $group);
        $this->chain($delegated);

        $this->getAssignedTurn($User, $date)->shouldBe(2);
    }

    public function it_can_manage_three_or_more_chained_rules(CantineUser $User, $group, \DateTime $date, $schedule, WeeklySchedule $altSchedule, WeeklySchedule $thirdSchedule)
    {
        $schedule->isScheduledDate($date)->willReturn(false);

        $delegated = $this->getDelegatedRule(2, false, $altSchedule, $date, $group);
        $this->chain($delegated);

        $lastDelegated = $this->getDelegatedRule(3, true, $thirdSchedule, $date, $group);
        $this->chain($lastDelegated);

        $this->getAssignedTurn($User, $date)->shouldBe(3);
    }

    public function it_returns_first_positive(CantineUser $User, $group, \DateTime $date, $schedule, WeeklySchedule $altSchedule)
    {
        $schedule->isScheduledDate($date)->willReturn(true);

        $delegated = $this->getDelegatedRule(2, true, $altSchedule, $date, $group);
        $this->chain($delegated);

        $this->getAssignedTurn($User, $date)->shouldBe(1);
    }

    private function getDelegatedRule($turn, $result, WeeklySchedule $altSchedule, \DateTime $date, $group)
    {
        $altSchedule->isScheduledDate($date)->willReturn($result);
        $delegated = new TurnRule($turn, $altSchedule->getWrappedObject(), $group->getWrappedObject(), [], []);

        return $delegated;
    }
}

<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\Turn;
use Milhojas\Domain\Cantine\Rule;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\CantineGroup;
use Milhojas\Domain\Utils\Schedule\WeeklySchedule;
use PhpSpec\ObjectBehavior;

class RuleSpec extends ObjectBehavior
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
        $this->shouldHaveType(Rule::class);
    }

    public function it_appoints_user_in_turn(
        $User,
        $turn,
        $group,
        \DateTimeImmutable $date,
        $schedule)
    {
        $schedule->isScheduledDate($date)->willReturn(true);
        $this->assignsUserToTurn($User, $date)->shouldBe($turn);
    }

    public function it_does_not_appoint_user_if_schedule_does_not_match(
        $User,
        $group,
        \DateTimeImmutable $date,
        $schedule)
    {
        $schedule->isScheduledDate($date)->willReturn(false);
        $this->assignsUserToTurn($User, $date)->shouldBe(false);
    }

    public function it_does_not_appoint_user_if_group_does_not_match(
        $User,
        $group,
        \DateTimeImmutable $date,
        $schedule)
    {
        $schedule->isScheduledDate($date)->willReturn(true);
        $User->belongsToGroup($group)->willReturn(false);
        $this->assignsUserToTurn($User, $date)->shouldBe(false);
    }

    public function it_delegates_to_another_rule_if_it_can_not_handle_conditions(
        $User,
        $turn,
        $schedule,
        \DateTimeImmutable $date,
        Rule $delegated

        ) {
        $schedule->isScheduledDate($date)->willReturn(false);
        $this->chain($delegated);
        $delegated->assignsUserToTurn($User, $date)->shouldBeCalled()->willReturn($turn);
        $this->assignsUserToTurn($User, $date)->shouldBe($turn);
    }

    public function it_does_nothing_if_it_can_not_assign_user_and_there_is_no_more_rules_in_the_chain(
        $User,
        $schedule,
        \DateTimeImmutable $date,
        Rule $rule

        ) {
        $schedule->isScheduledDate($date)->willReturn(false);
        $rule->assignsUserToTurn($User, $date)->shouldNotBeCalled();
        $this->assignsUserToTurn($User, $date)->shouldBe(false);
    }

    public function it_returns_first_positive(
        $User,
        $schedule,
        \DateTimeImmutable $date,
        Rule $delegated,
        $turn
        ) {
        $schedule->isScheduledDate($date)->willReturn(true);
        $this->chain($delegated);
        $delegated->assignsUserToTurn($User, $date)->shouldNotBeCalled();
        $this->assignsUserToTurn($User, $date)->shouldBe($turn);
    }
}

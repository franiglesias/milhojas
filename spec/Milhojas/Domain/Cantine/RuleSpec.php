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
        \DateTime $date,
        $schedule)
    {
        $schedule->isScheduledDate($date)->willReturn(true);
        $turn->appoint($User)->shouldBeCalled();
        $this->assignsUserToTurn($User, $date);
    }

    public function it_does_not_appoint_user_if_schedule_does_not_match(
        $User,
        $turn,
        $group,
        \DateTime $date,
        $schedule)
    {
        $schedule->isScheduledDate($date)->willReturn(false);
        $turn->appoint($User)->shouldNotBeCalled();
        $this->assignsUserToTurn($User, $date);
    }

    public function it_does_not_appoint_user_if_group_does_not_match(
        $User,
        $turn,
        $group,
        \DateTime $date,
        $schedule)
    {
        $schedule->isScheduledDate($date)->willReturn(true);
        $User->belongsToGroup($group)->willReturn(false);
        $turn->appoint($User)->shouldNotBeCalled();
        $this->assignsUserToTurn($User, $date);
    }

    public function it_delegates_to_another_rule_if_it_can_not_handle_conditions(
        $User,
        $turn,
        $schedule,
        \DateTime $date,
        Rule $rule

        ) {
        $schedule->isScheduledDate($date)->willReturn(false);
        $this->chain($rule);
        $turn->appoint($User)->shouldNotBeCalled();
        $rule->assignsUserToTurn($User, $date)->shouldBeCalled();
        $this->assignsUserToTurn($User, $date);
    }

    public function it_does_nothing_if_it_can_not_assign_user_and_there_is_no_more_rules_in_the_chain(
        $User,
        $turn,
        $schedule,
        \DateTime $date,
        Rule $rule

        ) {
        $schedule->isScheduledDate($date)->willReturn(false);
        $turn->appoint($User)->shouldNotBeCalled();
        $rule->assignsUserToTurn($User, $date)->shouldNotBeCalled();
        $this->assignsUserToTurn($User, $date);
    }

    public function it_returns_first_positive(
        $User,
        $turn,
        $schedule,
        \DateTime $date,
        Rule $rule

        ) {
        $schedule->isScheduledDate($date)->willReturn(true);
        $this->chain($rule);
        $turn->appoint($User)->shouldBeCalled();
        $rule->assignsUserToTurn($User, $date)->shouldNotBeCalled();
        $this->assignsUserToTurn($User, $date);
    }
}

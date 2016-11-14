<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\RegularCantineUser;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RegularCantineUserSpec extends ObjectBehavior
{
    function it_is_initializable($student_id, $week_days, $group_id)
    {
        $this->beConstructedWith($student_id, $week_days, $group_id);
        $this->shouldHaveType(RegularCantineUser::class);
    }

    public function it_can_be_asked_for_assigned_turn($student_id, $week_days, $group_id, $user, $date)
    {
        $this->beConstructedWith($student_id, $week_days, $group_id);
        $turn = $this->getAssignedTurn($user, $date)->shouldReturn(1);
    }
}

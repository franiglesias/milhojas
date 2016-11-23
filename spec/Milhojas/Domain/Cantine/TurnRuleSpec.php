<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\TurnRule;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\CantineGroup;
use Milhojas\Domain\Utils\WeeklySchedule;
use PhpSpec\ObjectBehavior;

class TurnRuleSpec extends ObjectBehavior
{
    public function let(WeeklySchedule $schedule, CantineGroup $group, $enrolled, $notEnrolled)
    {
        $this->beConstructedWith(3, $schedule, $group, [$enrolled], [$notEnrolled]);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(TurnRule::class);
    }
    public function it_assigns_turn(CantineUser $User, $group, $enrolled, $notEnrolled, \DateTime $date, $schedule)
    {
        $schedule->isScheduledDate($date)->willReturn(true);
        $User->belongsToGroup($group)->willReturn(true);
        $User->isEnrolled()->willReturn($enrolled);
        $this->getAssignedTurn($User, $date)->shouldBe(3);
    }
}

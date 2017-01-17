<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\Event\CantineSeatsHasBeenAssigned;
use Milhojas\Domain\Cantine\Event\UserWasAssignedToCantineTurn;
use Milhojas\Domain\Cantine\Event\UserWasNotAssignedToCantineTurn;
use Milhojas\Domain\Cantine\Rule;
use Milhojas\Domain\Cantine\Turn;
use Milhojas\Domain\Cantine\Assigner;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\Exception\CantineUserCouldNotBeAssignedToTurn;
use Milhojas\Domain\Cantine\Factories\CantineManager;
use Milhojas\Library\Messaging\EventBus\EventRecorder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AssignerSpec extends ObjectBehavior
{
    private $fileSystem;

    public function let(CantineManager $cantineManager, EventRecorder $recorder, Rule $rule)
    {
        $cantineManager->getRules()->willReturn($rule);
        $this->beConstructedWith($cantineManager, $recorder);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Assigner::class);
    }

    public function it_builds_cantine_list(CantineUser $user1, CantineUser $user2, \DateTimeImmutable $date, $rule, Turn $turn)
    {
        $rule->assignsUserToTurn($user1, $date)->shouldBeCalled()->willReturn($turn);
        $rule->assignsUserToTurn($user2, $date)->shouldBeCalled()->willReturn($turn);
        $this->assign($date, [$user1, $user2]);
    }

    public function it_records_events(CantineUser $user1, CantineUser $user2, \DateTimeImmutable $date, $rule, $recorder, Turn $turn)
    {
        $rule->assignsUserToTurn($user1, $date)->shouldBeCalled()->willReturn($turn);
        $rule->assignsUserToTurn($user2, $date)->willThrow(CantineUserCouldNotBeAssignedToTurn::class);
        $recorder->recordThat(Argument::type(UserWasAssignedToCantineTurn::class))->shouldBeCalled();
        $recorder->recordThat(Argument::type(UserWasNotAssignedToCantineTurn::class))->shouldBeCalled();
        $recorder->recordThat(Argument::type(CantineSeatsHasBeenAssigned::class))->shouldBeCalled();

        $this->assign($date, [$user1, $user2]);
    }
}

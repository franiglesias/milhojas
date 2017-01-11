<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Application\Cantine\Event\UserWasAssignedToCantineTurn;
use Milhojas\Application\Cantine\Event\UserWasNotAssignedToCantineTurn;
use Milhojas\Domain\Cantine\Rule;
use Milhojas\Domain\Cantine\Turn;
use Milhojas\Domain\Cantine\Assigner;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\CantineList\CantineList;
use Milhojas\Domain\Cantine\Exception\CantineUserCouldNotBeAssignedToTurn;
use Milhojas\Domain\Cantine\Factories\CantineManager;
use Milhojas\Library\Messaging\EventBus\EventBus;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AssignerSpec extends ObjectBehavior
{
    private $fileSystem;

    public function let(CantineManager $cantineManager, EventBus $dispatcher, Rule $rule)
    {
        $cantineManager->getRules()->willReturn($rule);
        $this->beConstructedWith($cantineManager, $dispatcher);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Assigner::class);
    }

    public function it_builds_cantine_list(CantineUser $user1, CantineUser $user2, \DateTimeImmutable $date, $rule, Turn $turn)
    {
        $rule->assignsUserToTurn($user1, $date)->shouldBeCalled()->willReturn($turn);
        $rule->assignsUserToTurn($user2, $date)->shouldBeCalled()->willReturn($turn);
        $this->buildList($date, [$user1, $user2])->shouldHaveType(CantineList::class);
    }

    public function it_raises_events(CantineUser $user1, CantineUser $user2, \DateTimeImmutable $date, $rule, $dispatcher, Turn $turn)
    {
        $rule->assignsUserToTurn($user1, $date)->shouldBeCalled()->willReturn($turn);
        $rule->assignsUserToTurn($user2, $date)->willThrow(CantineUserCouldNotBeAssignedToTurn::class);
        $dispatcher->dispatch(Argument::type(UserWasAssignedToCantineTurn::class))->shouldBeCalled();
        $dispatcher->dispatch(Argument::type(UserWasNotAssignedToCantineTurn::class))->shouldBeCalled();

        $this->buildList($date, [$user1, $user2])->shouldHaveType(CantineList::class);
    }
}

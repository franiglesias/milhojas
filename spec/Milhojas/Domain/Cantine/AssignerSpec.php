<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Application\Cantine\Event\UserWasAssignedToCantineTurn;
use Milhojas\Application\Cantine\Event\UserWasNotAssignedToCantineTurn;
use Milhojas\Domain\Cantine\Rule;
use Milhojas\Domain\Cantine\Turn;
use Milhojas\Domain\Cantine\Assigner;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\CantineList;
use Milhojas\Library\EventBus\EventBus;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AssignerSpec extends ObjectBehavior
{
    private $fileSystem;

    public function let(Rule $rule, EventBus $dispatcher)
    {
        $this->beConstructedWith($rule, $dispatcher);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Assigner::class);
    }

    public function it_assigns_turns(CantineUser $user1, CantineUser $user2, \DateTimeImmutable $date, $rule)
    {
        $rule->assignsUserToTurn($user1, $date)->shouldBeCalled();
        $rule->assignsUserToTurn($user2, $date)->shouldBeCalled();
        $this->assignUsersForDate([$user1, $user2], $date);
    }

    public function it_builds_cantine_list(CantineUser $user1, CantineUser $user2, \DateTimeImmutable $date, $rule, Turn $turn)
    {
        $rule->assignsUserToTurn($user1, $date)->shouldBeCalled()->willReturn($turn);

        $rule->assignsUserToTurn($user2, $date)->shouldBeCalled()->willReturn($turn);

        $list = new CantineList($date->getWrappedObject());
        $this->buildList($list, [$user1, $user2]);
    }

    public function it_raise_events(CantineUser $user1, CantineUser $user2, \DateTimeImmutable $date, $rule, $dispatcher, Turn $turn)
    {
        $rule->assignsUserToTurn($user1, $date)->shouldBeCalled()->willReturn($turn);
        $rule->assignsUserToTurn($user2, $date)->shouldBeCalled()->willReturn(false);
        $dispatcher->dispatch(Argument::type(UserWasAssignedToCantineTurn::class))->shouldBeCalled();
        $dispatcher->dispatch(Argument::type(UserWasNotAssignedToCantineTurn::class))->shouldBeCalled();
        $this->assignUsersForDate([$user1, $user2], $date);
    }
}

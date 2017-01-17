<?php

namespace spec\Milhojas\Application\Cantine\Listener;

use Milhojas\Domain\Cantine\Turn;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\CantineList\CantineListUserRecord;
use Milhojas\Domain\Cantine\Event\UserWasAssignedToCantineTurn;
use Milhojas\Application\Cantine\Listener\AddUserToCantineList;
use Milhojas\Domain\Cantine\CantineList\CantineListRepository;
use Milhojas\Library\Messaging\EventBus\EventHandler;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AddUserToCantineListSpec extends ObjectBehavior
{
    public function let(CantineListRepository $cantineListRepository)
    {
        $this->beConstructedWith($cantineListRepository);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(AddUserToCantineList::class);
        $this->shouldImplement(EventHandler::class);
    }

    public function it_add_user_to_cantine_list_repository(UserWasAssignedToCantineTurn $event, $cantineListRepository, CantineUser $user, Turn $turn, \DateTime $date)
    {
        $event->getUser()->shouldBeCalled()->willReturn($user);
        $event->getTurn()->shouldBeCalled()->willReturn($turn);
        $event->getDate()->shouldBeCalled()->willReturn($date);
        $cantineListRepository->store(Argument::type(CantineListUserRecord::class))->shouldBeCalled();
        $this->handle($event);
    }
}

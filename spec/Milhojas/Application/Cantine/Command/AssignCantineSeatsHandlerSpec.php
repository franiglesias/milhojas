<?php

namespace spec\Milhojas\Application\Cantine\Command;

use Milhojas\Application\Cantine\Command\AssignCantineSeats;
use Milhojas\Application\Cantine\Command\AssignCantineSeatsHandler;
use Milhojas\Domain\Cantine\Assigner;
use Milhojas\Domain\Cantine\CantineUserRepository;
use Milhojas\Library\Messaging\CommandBus\CommandHandler;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AssignCantineSeatsHandlerSpec extends ObjectBehavior
{
    public function let(Assigner $assigner, CantineUserRepository $repository)
    {
        $this->beConstructedWith($assigner, $repository);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(AssignCantineSeatsHandler::class);
        $this->shouldImplement(CommandHandler::class);
    }

    public function it_handles_AssignCantineSeats_commands(AssignCantineSeats $command, \DateTime $date, $assigner, $repository)
    {
        $users = [];
        $command->getDate()->shouldBeCalled()->willReturn($date);
        $repository->find(Argument::any())->willReturn($users);
        $assigner->assign($date, $users);
        $this->handle($command);
    }
}

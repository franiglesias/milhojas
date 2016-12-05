<?php

namespace spec\Milhojas\Application\Cantine\Command;

use Milhojas\Application\Cantine\Command\RegisterStudentAsCantineUser;
use Milhojas\Application\Cantine\Command\RegisterStudentAsCantineUserHandler;
use Milhojas\Library\CommandBus\CommandBus;
use Milhojas\Library\CommandBus\CommandHandler;
use Milhojas\Domain\Utils\Schedule\Schedule;
use Milhojas\Domain\School\Student;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\CantineUserRepository;
use Milhojas\Library\CommandBus\Commands\BroadcastEvent;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RegisterStudentAsCantineUserHandlerSpec extends ObjectBehavior
{
    public function let(CantineUserRepository $cantineUserRepository, CommandBus $commandBus)
    {
        $this->beConstructedWith($cantineUserRepository, $commandBus);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(RegisterStudentAsCantineUserHandler::class);
        $this->shouldImplement(CommandHandler::class);
    }

    public function it_handles_the_command_and_register_users(RegisterStudentAsCantineUser $command, Student $student, Schedule $schedule, $cantineUserRepository, $commandBus)
    {
        $command->getStudent()->shouldBeCalled()->willReturn($student);
        $command->getSchedule()->shouldBeCalled()->willReturn($schedule);
        $cantineUserRepository->store(Argument::type(CantineUser::class))->shouldBeCalled();

        $this->handle($command);
    }

    public function it_handles_the_command_and_raises_event(RegisterStudentAsCantineUser $command, Student $student, Schedule $schedule, $commandBus)
    {
        $command->getStudent()->shouldBeCalled()->willReturn($student);
        $command->getSchedule()->shouldBeCalled()->willReturn($schedule);

        $commandBus->execute(Argument::type(BroadcastEvent::class))->shouldBeCalled();
        $this->handle($command);
    }
}

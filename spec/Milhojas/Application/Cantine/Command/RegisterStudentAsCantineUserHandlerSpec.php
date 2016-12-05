<?php

namespace spec\Milhojas\Application\Cantine\Command;

use Milhojas\Application\Cantine\Command\RegisterStudentAsCantineUser;
use Milhojas\Application\Cantine\Command\RegisterStudentAsCantineUserHandler;
use Milhojas\Library\CommandBus\CommandHandler;
use PhpSpec\ObjectBehavior;

class RegisterStudentAsCantineUserHandlerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(RegisterStudentAsCantineUserHandler::class);
        $this->shouldImplement(CommandHandler::class);
    }

    public function it_handles_the_command(RegisterStudentAsCantineUser $command)
    {
        $this->handle($command);
    }
}

<?php

namespace spec\Milhojas\Application\Shared\Command;

use Milhojas\Application\Shared\Command\EnrollStudentHandler;
use Milhojas\Application\Shared\Command\EnrollStudent;
use Milhojas\Domain\Shared\Event\StudentWasEnrolled;
use Milhojas\Messaging\CommandBus\CommandHandler;
use Milhojas\Messaging\EventBus\EventRecorder;
use Milhojas\Domain\Shared\StudentServiceRepository;
use Milhojas\Domain\Shared\Student;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EnrollStudentHandlerSpec extends ObjectBehavior
{
    public function let(StudentServiceRepository $repository, EventRecorder $recorder)
    {
        $this->beConstructedWith($repository, $recorder);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(EnrollStudentHandler::class);
        $this->shouldImplement(CommandHandler::class);
    }

    public function it_handles_EnrollStudent_command(EnrollStudent $command, $repository, $recorder)
    {
        $repository->store(Argument::type(Student::class))->shouldBeCalled();
        $recorder->recordThat(Argument::type(StudentWasEnrolled::class))->shouldBeCalled();
        $this->handle($command);
    }
}

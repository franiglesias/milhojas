<?php

namespace Milhojas\Application\Shared\Command;

use Milhojas\Messaging\CommandBus\Command;
use Milhojas\Messaging\CommandBus\CommandHandler;
use Milhojas\Messaging\EventBus\EventRecorder;
use Milhojas\Domain\Shared\Student;
use Milhojas\Domain\Shared\StudentId;
use Milhojas\Domain\Shared\StudentServiceRepository;
use Milhojas\Domain\Shared\Event\StudentWasEnrolled;

class EnrollStudentHandler implements CommandHandler
{
    /**
     * @var StudentServiceRepository
     */
    private $repository;
    /**
     * @var EventRecorder
     */
    private $recorder;

    public function __construct(StudentServiceRepository $repository, EventRecorder $recorder)
    {
        $this->repository = $repository;
        $this->recorder = $recorder;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Command $command)
    {
        $student = new Student(StudentId::generate(), $command->getPerson(), '', '');
        $this->repository->store($student);
        $this->recorder->recordThat(new StudentWasEnrolled($student));
    }
}

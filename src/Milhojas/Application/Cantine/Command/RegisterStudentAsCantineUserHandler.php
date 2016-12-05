<?php

namespace Milhojas\Application\Cantine\Command;

use Milhojas\Domain\Cantine\Event\StudentWasRegisteredAsCantineUser;
use Milhojas\Library\CommandBus\Command;
use Milhojas\Library\CommandBus\CommandHandler;
use Milhojas\Library\CommandBus\Commands\BroadcastEvent;
use Milhojas\Library\CommandBus\CommandBus;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\CantineUserRepository;

class RegisterStudentAsCantineUserHandler implements CommandHandler
{
    private $cantineUserRepository;
    private $commandBus;

    public function __construct(CantineUserRepository $cantineUserRepository, CommandBus $commandBus)
    {
        $this->cantineUserRepository = $cantineUserRepository;
        $this->commandBus = $commandBus;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Command $command)
    {
        $user = CantineUser::apply($command->getStudent(), $command->getSchedule());
        $this->cantineUserRepository->store($user);
        $this->commandBus->execute(new BroadcastEvent(new StudentWasRegisteredAsCantineUser($command->getStudent(), $user)));
    }
}

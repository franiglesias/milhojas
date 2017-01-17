<?php

namespace Milhojas\Application\Cantine\Command;

use Milhojas\Domain\Cantine\Assigner;
use Milhojas\Domain\Cantine\CantineUserRepository;
use Milhojas\Domain\Cantine\Specification\CantineUserEatingOnDate;
use Milhojas\Library\Messaging\CommandBus\CommandHandler;
use Milhojas\Library\Messaging\CommandBus\Command;

class AssignCantineSeatsHandler implements CommandHandler
{
    /**
     * @var Assigner
     */
    private $assigner;
    /**
     * @var CantineUserRespository
     */
    private $cantineUserRepository;

    public function __construct(Assigner $assigner, CantineUserRepository $cantineUserRepository)
    {
        $this->assigner = $assigner;
        $this->cantineUserRepository = $cantineUserRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Command $command)
    {
        $date = $command->getDate();
        $users = $this->cantineUserRepository->find(new CantineUserEatingOnDate($date));
        $this->assigner->assign($date, $users);
    }
}

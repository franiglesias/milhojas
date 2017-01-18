<?php

namespace Milhojas\Application\Cantine\Listener;

use Milhojas\Domain\Cantine\CantineList\CantineSeat;
use Milhojas\Library\Messaging\EventBus\Event;
use Milhojas\Library\Messaging\EventBus\Listener;
use Milhojas\Domain\Cantine\CantineList\CantineSeatRepository;

class AddUserToCantineList implements Listener
{
    /**
     * @var CantineSeatRepository
     */
    private $repository;

    public function __construct(CantineSeatRepository $cantineListRepository)
    {
        $this->repository = $cantineListRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Event $event)
    {
        $record = CantineSeat::createFromUserTurnAndDate($event->getUser(), $event->getTurn(), $event->getDate());
        $this->repository->store($record);
    }
}

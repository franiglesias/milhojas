<?php

namespace Milhojas\Application\Cantine\Listener;

use Milhojas\Domain\Cantine\CantineList\CantineListUserRecord;
use Milhojas\Library\Messaging\EventBus\Event;
use Milhojas\Library\Messaging\EventBus\EventHandler;
use Milhojas\Domain\Cantine\CantineList\CantineListRepository;

class AddUserToCantineList implements EventHandler
{
    /**
     * @var CantineListRepository
     */
    private $repository;

    public function __construct(CantineListRepository $cantineListRepository)
    {
        $this->repository = $cantineListRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Event $event)
    {
        $record = CantineListUserRecord::createFromUserTurnAndDate($event->getUser(), $event->getTurn(), $event->getDate());
        $this->repository->store($record);
    }
}

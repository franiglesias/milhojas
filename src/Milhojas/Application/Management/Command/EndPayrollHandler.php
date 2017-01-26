<?php

namespace Milhojas\Application\Management\Command;

use League\Flysystem\FilesystemInterface;
use Milhojas\Application\Management\Event\AllPayrollsWereSent;
use Milhojas\Messaging\CommandBus\Command;
use Milhojas\Messaging\CommandBus\CommandHandler;
use Milhojas\Messaging\EventBus\EventRecorder;

class EndPayrollHandler implements CommandHandler
{
    /**
     * Event recorder.
     *
     * @var EventRecorder
     */
    private $recorder;
    /**
     * @param string              $file
     * @param FilesystemInterface $fs
     * @param EventRecorder       $recorder
     */
    public function __construct(
        EventRecorder $recorder
    ) {
        $this->recorder = $recorder;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Command $command)
    {
        $this->recorder->recordThat(new AllPayrollsWereSent($command->getProgress(), $command->getMonth()));
    }
}

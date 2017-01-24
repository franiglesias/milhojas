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
     * File to start.
     *
     * @var string
     */
    private $file;

    /**
     * FileSystemStorage.
     *
     * @var FilesystemInterface
     */
    private $fs;
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
        $file,
        FilesystemInterface $fs,
        EventRecorder $recorder
    ) {
        $this->file = $file;
        $this->fs = $fs;
        $this->recorder = $recorder;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Command $command)
    {
        $this->fs->delete($this->file);
        $this->recorder->recordThat(new AllPayrollsWereSent($command->getProgress(), $command->getMonth()));
    }
}

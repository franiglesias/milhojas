<?php

namespace Milhojas\Application\Management\Reporter;

use League\Flysystem\FilesystemInterface;
use Milhojas\Messaging\EventBus\Listener;
use Milhojas\Messaging\EventBus\Event;

/**
 * Writes Payroll Distribution Progress to the json file specified in the constructor.
 */
class PayrollProgressReporter implements Listener
{
    /**
     * @var string
     */
    private $file;
    /**
     * @var FilesystemInterface
     */
    private $fs;
    public function __construct($file, FilesystemInterface $fs)
    {
        $this->fs = $fs;
        $this->file = $file;
    }

    public function handle(Event $event)
    {
        $this->fs->put($this->file, $event->getProgressDataAsJson());
    }
}

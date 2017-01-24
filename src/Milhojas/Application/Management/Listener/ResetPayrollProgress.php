<?php

namespace Milhojas\Application\Management\Listener;

use League\Flysystem\FilesystemInterface;
use Milhojas\Messaging\EventBus\Listener;
use Milhojas\Messaging\EventBus\Event;

/**
 * Resets Payroll Distribution Progress exchange file.
 */
class ResetPayrollProgress implements Listener
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
        $this->file = $file;
        $this->fs = $fs;
    }

    public function handle(Event $event)
    {
        $this->fs->delete($this->file);
    }
}

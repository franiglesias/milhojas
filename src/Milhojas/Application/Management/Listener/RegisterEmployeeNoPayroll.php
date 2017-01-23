<?php

namespace Milhojas\Application\Management\Listener;

use League\Flysystem\FilesystemInterface;
use Milhojas\Messaging\EventBus\Listener;
use Milhojas\Messaging\EventBus\Event;

class RegisterEmployeeNoPayroll implements Listener
{
    /**
     * Path to the buffer file to store partial data.
     *
     * @var mixed
     */
    private $file;
    /**
     * A filesystem abstraction.
     *
     * @var FilesystemInterface
     */
    private $fs;
    public function __construct($file, FilesystemInterface $filesystem)
    {
        $this->file = $file;
        $this->fs = $filesystem;
    }

    public function handle(Event $event)
    {
        $employee = $event->getEmployee();
        $name = $employee->getFullName();
        $this->writeData($name);
    }

    private function writeData($data)
    {
        $contents = '';
        if ($this->fs->has($this->file)) {
            $contents = $this->fs->read($this->file);
        }
        $this->fs->put($this->file, $contents.$data.PHP_EOL);
    }
}

<?php

namespace Milhojas\Application\Management\Listener;

use League\Flysystem\FilesystemInterface;
use Milhojas\Domain\Management\Payrolls;
use Milhojas\Messaging\EventBus\Event;
use Milhojas\Messaging\EventBus\Listener;


class ArchiveSentPayrolls implements Listener
{
    /**
     * @var Payrolls
     */
    private $payrolls;
    /**
     * @var FilesystemInterface
     */
    private $filesystem;

    public function __construct(Payrolls $payrolls, FilesystemInterface $filesystem)
    {
        $this->payrolls = $payrolls;
        $this->filesystem = $filesystem;
    }

    public function handle(Event $event)
    {
        $employee = $event->getEmployee();
        $month = $event->getMonth();
        $this->payrolls->archive($employee, $month);
    }
}

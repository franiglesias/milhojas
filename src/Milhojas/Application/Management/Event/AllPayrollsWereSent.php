<?php

namespace Milhojas\Application\Management\Event;

use Milhojas\Messaging\EventBus\Event;
use Milhojas\Library\ValueObjects\Misc\Progress;

/**
 * All payrolls were sent.
 */
class AllPayrollsWereSent implements Event
{
    private $month;
    private $progress;

    public function __construct(Progress $progress, $month)
    {
        $this->month = $month;
        $this->progress = $progress;
    }

    public function getMonth()
    {
        return $this->month;
    }

    public function getProgress()
    {
        return $this->progress;
    }

    public function getName()
    {
        return 'management.all_payrolls_were_sent.event';
    }

    public function __toString()
    {
        return 'El envío de nóminas se ha completado.';
    }

    public function getCurrentProgress()
    {
        return $this->progress->getCurrent();
    }

    public function getTotalProgress()
    {
        return $this->progress->getTotal();
    }
    public function getSentProgress()
    {
        return $this->progress->getSent();
    }
    public function getNotFoundProgress()
    {
        return $this->progress->getNotFound();
    }
    public function getFailedProgress()
    {
        return $this->progress->getFailed();
    }
}

<?php

namespace Milhojas\Application\Management\Command;

use Milhojas\Domain\Management\PayrollMonth;
use Milhojas\Domain\Management\PayrollReporter;
use Milhojas\Messaging\CommandBus\Command;

class EndPayroll implements Command
{
    /**
     * @var PayrollMonth
     */
    private $month;
    /**
     * @var PayrollReporter
     */
    private $progress;

    /**
     * @param PayrollMonth    $month
     * @param PayrollReporter $progress
     */
    public function __construct(PayrollMonth $month, PayrollReporter $progress)
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
}

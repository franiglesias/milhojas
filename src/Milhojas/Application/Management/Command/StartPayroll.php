<?php

namespace Milhojas\Application\Management\Command;

use Milhojas\Domain\Management\PayrollReporter;
use Milhojas\Messaging\CommandBus\Command;

class StartPayroll implements Command
{
    /**
     * @var PayrollReporter
     */
    private $progress;

    /**
     * @param PayrollReporter $progress
     */
    public function __construct(PayrollReporter $progress)
    {
        $this->progress = $progress;
    }
    /**
     * @return PayrollReporter
     */
    public function getProgress()
    {
        return $this->progress;
    }
}

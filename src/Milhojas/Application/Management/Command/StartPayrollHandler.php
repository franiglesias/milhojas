<?php

namespace Milhojas\Application\Management\Command;

use Milhojas\Application\Management\PayrollProgressExchange;
use Milhojas\Application\Management\Event\PayrollDistributionStarted;
use Milhojas\Messaging\CommandBus\CommandHandler;
use Milhojas\Messaging\CommandBus\Command;
use Milhojas\Messaging\EventBus\EventRecorder;

class StartPayrollHandler implements CommandHandler
{
    /**
     * PayrollProgressExchange.
     *
     * @var PayrollProgressExchange
     */
    private $exchanger;
    /**
     * Event recorder.
     *
     * @var EventRecorder
     */
    private $recorder;
    /**
     * @param PayrollProgressExchange $exchanger
     * @param EventRecorder           $recorder
     */
    public function __construct(PayrollProgressExchange $exchanger, EventRecorder $recorder)
    {
        $this->exchanger = $exchanger;
        $this->recorder = $recorder;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Command $command)
    {
        $this->exchanger->init();
        $this->recorder->recordThat(new PayrollDistributionStarted($command->getProgress()));
    }
}

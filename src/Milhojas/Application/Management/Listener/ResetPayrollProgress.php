<?php

namespace Milhojas\Application\Management\Listener;

use Milhojas\Application\Management\PayrollProgressExchange;
use Milhojas\Messaging\EventBus\Listener;
use Milhojas\Messaging\EventBus\Event;

/**
 * Resets Payroll Distribution Progress exchange file.
 */
class ResetPayrollProgress implements Listener
{
    /**
     * @var PayrollProgressExchange
     */
    private $exchanger;

    public function __construct(PayrollProgressExchange $exchanger)
    {
        $this->exchanger = $exchanger;
    }

    public function handle(Event $event)
    {
        $this->exchanger->reset();
    }
}

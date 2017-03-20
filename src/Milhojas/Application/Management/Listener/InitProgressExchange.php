<?php

namespace Milhojas\Application\Management\Listener;

use Milhojas\Application\Management\PayrollProgressExchange;

use Milhojas\Messaging\EventBus\Event;

use Milhojas\Messaging\EventBus\Listener;


class InitProgressExchange implements Listener
{
    /**
     * PayrollProgressExchange.
     *
     * @var PayrollProgressExchange
     */
    private $exchanger;

    /**
     * @param PayrollProgressExchange $exchanger
     */
    public function __construct(PayrollProgressExchange $exchanger)
    {
        $this->exchanger = $exchanger;

    }

    /**
     * {@inheritdoc}
     */
    public function handle(Event $event)
    {
        $this->exchanger->init();
    }
}

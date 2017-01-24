<?php

namespace spec\Milhojas\Application\Management\Listener;

use Milhojas\Application\Management\PayrollProgressExchange;
use Milhojas\Application\Management\Event\AllPayrollsWereSent;
use Milhojas\Application\Management\Listener\ResetPayrollProgress;
use PhpSpec\ObjectBehavior;

class ResetPayrollProgressSpec extends ObjectBehavior
{
    public function let(PayrollProgressExchange $exchange)
    {
        $this->beConstructedWith($exchange);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ResetPayrollProgress::class);
    }

    public function it_handles_AllPayrollsWereSent_event(AllPayrollsWereSent $event, $exchange)
    {
        $exchange->reset()->shouldBeCalled();
        $this->handle($event);
    }
}

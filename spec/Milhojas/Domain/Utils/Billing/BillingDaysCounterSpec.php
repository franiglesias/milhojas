<?php

namespace spec\Milhojas\Domain\Utils\Billing;

use League\Period\Period;
use Milhojas\Domain\Utils\Billing\BillingDaysCounter;
use Milhojas\Domain\Utils\Schedule\Schedule;
use PhpSpec\ObjectBehavior;

class BillingDaysCounterSpec extends ObjectBehavior
{
    public function let(Period $month)
    {
        $this->beConstructedWith($month);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(BillingDaysCounter::class);
    }

    public function it_can_tell_month_name($month)
    {
        $month->getStartDate()->willReturn(new \DateTimeImmutable('11/1/2016'));
        $this->getMonth()->shouldBe('november');
    }

    public function it_can_set_and_get_billing_dates(Schedule $schedule, $month)
    {
        $schedule->scheduledDays($month)->willReturn(4);
        $this->count($schedule);
        $this->getDays()->shouldBe(4);
    }
}

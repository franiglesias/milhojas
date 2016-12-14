<?php

namespace spec\Milhojas\Domain\Utils\Billing;

use Milhojas\Domain\Utils\Billing\BillingDaysCounter;
use Milhojas\Domain\Utils\Schedule\Schedule;
use Milhojas\Library\ValueObjects\Dates\MonthYear;
use PhpSpec\ObjectBehavior;

class BillingDaysCounterSpec extends ObjectBehavior
{
    public function let(MonthYear $month)
    {
        $this->beConstructedWith($month);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(BillingDaysCounter::class);
    }

    public function it_can_tell_month_name($month)
    {
        $month->getMonthName()->willReturn('november');
        $this->getMonth()->shouldBe('november');
    }

    public function it_can_set_and_get_billing_dates(Schedule $schedule)
    {
        $this->count(10);
        $this->getDays()->shouldBe(10);
    }
}

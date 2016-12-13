<?php

namespace spec\Milhojas\Domain\Utils\Billing;

use Milhojas\Domain\Utils\Billing\BillingDaysCounter;
use Milhojas\Domain\Utils\Schedule\Schedule;
use Milhojas\Library\ValueObjects\Dates\MonthYear;
use PhpSpec\ObjectBehavior;

class BillingDaysCounterSpec extends ObjectBehavior
{
    public function let(Schedule $schedule)
    {
        $this->beConstructedWith($schedule);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(BillingDaysCounter::class);
    }

    public function it_can_count_billing_days_in_month(MonthYear $month, $schedule)
    {
        $month->hasDays()->willReturn(30);
        $month->asString()->willReturn('11/2016');
        $dates = $this->generateDates();
        $count = 0;
        foreach ($dates as $date) {
            $schedule->isScheduledDate($date)->willReturn($count < 10);
            ++$count;
        }
        $this->forMonth($month)->shouldBe(10);
    }

    private function generateDates()
    {
        for ($i = 1; $i <= 30; ++$i) {
            $dates[] = new \DateTime('11/'.$i.'/2016');
        }

        return $dates;
    }
}

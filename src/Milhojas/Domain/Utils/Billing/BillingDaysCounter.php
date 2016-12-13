<?php

namespace Milhojas\Domain\Utils\Billing;

use Milhojas\Domain\Utils\Schedule\Schedule;
use Milhojas\Library\ValueObjects\Dates\MonthYear;
use League\Period\Period;

class BillingDaysCounter
{
    /**
     * The schedule we are interested.
     *
     * @var Schedule
     */
    private $schedule;

    /**
     * @param Schedule $schedule
     */
    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }

    public function forMonth(MonthYear $month)
    {
        $count = 0;
        list($month, $year) = explode('/', $month->asString());
        $period = Period::createFromMonth($year, $month);
        foreach ($period->getDatePeriod('1 DAY') as $day) {
            $count += $this->schedule->isScheduledDate($day) ? 1 : 0;
        }

        return $count;
    }
}

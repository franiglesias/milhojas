<?php

namespace Milhojas\Domain\Utils\Billing;

use Milhojas\Domain\Utils\Schedule\Schedule;
use Milhojas\Library\ValueObjects\Dates\MonthYear;

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
        $days = $month->hasDays();
        list($month, $year) = explode('/', $month->asString());
        for ($day = 1; $day <= $days; ++$day) {
            $date = new \DateTime(sprintf('%s/%s/%s', $month, $day, $year));
            $count += $this->schedule->isScheduledDate($date) ? 1 : 0;
        }

        return $count;
    }
}

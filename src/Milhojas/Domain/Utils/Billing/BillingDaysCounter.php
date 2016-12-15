<?php

namespace Milhojas\Domain\Utils\Billing;

use League\Period\Period;
use Milhojas\Domain\Utils\Schedule\Schedule;

/**
 * Visitor counter for Schedules.
 */
class BillingDaysCounter
{
    /**
     * The schedule we are interested.
     *
     * @var Schedule
     */
    private $month;
    private $days;

    /**
     * @param Schedule $schedule
     */
    public function __construct(Period $month)
    {
        $this->month = $month;
    }

    public function getMonth()
    {
        return strtolower($this->month->getStartDate()->format('F'));
    }

    public function count(Schedule $schedule)
    {
        $this->days = $schedule->scheduledDays($this->month);
    }

    public function getDays()
    {
        return $this->days;
    }
}

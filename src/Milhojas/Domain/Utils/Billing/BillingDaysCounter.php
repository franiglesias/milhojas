<?php

namespace Milhojas\Domain\Utils\Billing;

use Milhojas\Library\ValueObjects\Dates\MonthYear;

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
    public function __construct(MonthYear $month)
    {
        $this->month = $month;
    }

    public function getMonth()
    {
        return $this->month->getMonthName();
    }

    public function count(Schedule $schedule)
    {
        $this->days = $days;
    }

    public function getDays()
    {
        return $this->days;
    }
}

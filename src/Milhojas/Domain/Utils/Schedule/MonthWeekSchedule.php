<?php

namespace Milhojas\Domain\Utils\Schedule;

use Milhojas\Domain\Utils\Billing\BillingDaysCounter;
use League\Period\Period;

class MonthWeekSchedule extends Schedule
{
    public function __construct($schedule)
    {
        foreach ($schedule as $month => $weekDays) {
            $month = strtolower($month);
            $this->isValidMonth($month);
            $this->schedule[$month] = new WeeklySchedule($weekDays);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isScheduledDate(\DateTimeInterface $date)
    {
        if ($this->thereIsAppointmentToThisDate($date)) {
            return true;
        }

        return $this->delegate($date);
    }

    private function thereIsAppointmentToThisDate(\DateTimeInterface $date)
    {
        $month = strtolower($date->format('F'));

        if (!isset($this->schedule[$month])) {
            return false;
        }

        return $this->schedule[$month]->isScheduledDate($date);
    }

    private function isValidMonth($month)
    {
        if (!in_array($month, ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'october', 'november', 'december'])) {
            throw new \InvalidArgumentException(sprintf('%s is not a valid month', $month));
        }
    }

    public function countDays(BillingDaysCounter $counter)
    {
        throw new \LogicException('Not implemented'); // TODO
    }

    /**
     * {@inheritdoc}
     */
    public function scheduledDays(Period $period)
    {
        throw new \LogicException('Not implemented'); // TODO
    }

    /**
     * {@inheritdoc}
     */
    public function realDays(Period $period)
    {
        throw new \LogicException('Not implemented'); // TODO
    }
}

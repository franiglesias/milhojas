<?php

namespace Milhojas\Domain\Utils\Schedule;

use League\Period\Period;
use Milhojas\Domain\Utils\Billing\BillingDaysCounter;

abstract class Schedule
{
    protected $schedule;
    private $next;

    /**
     * Tells if the given date is on the schedule.
     *
     * @param \DateTimeInterface $date
     *
     * @return bool true if dates is on schedule
     */
    abstract public function isScheduledDate(\DateTimeInterface $date);
    /**
     * Counts effective days in the schedule in a Month for billing purposes, so usually they are week basis.
     *
     * @param BillingDaysCounter $counter
     */
    abstract public function countDays(BillingDaysCounter $counter);
    abstract public function scheduledDays(Period $period);
    abstract public function realDays(Period $period);
     /**
      * Merges current schedule with a new schedule.
      *
      * @param Schedule $delta
      *
      * @return Schedule A new instance with the updated schedule
      *
      * @throws InvalidArgumentException If passed Schedule isn't of the same type
      */
     public function update(Schedule $delta)
     {
         $this->isValidSchedule($delta);
         $updated = clone $this;
         $updated->schedule = array_merge($this->schedule, $delta->schedule);

         return $updated;
     }

    /**
     * Adds another Schedule to the Chain of Responsibility so we can merge different types.
     *
     * @param Schedule $nextSchedule The next schedule in the chain
     */
    public function setNext(Schedule $nextSchedule)
    {
        if (!$this->next) {
            $this->next = $nextSchedule;

            return;
        }

        $this->next->setNext($nextSchedule);
    }

    /**
     * Utility method delegates to the next schedule in the chain or returns false if it's the last.
     *
     * @param \DateTimeInterface $date
     *
     * @return bool true if the date is on schedule in the delegate, false if thers is no mor schedules in the chain
     */
    protected function delegate(\DateTimeInterface $date)
    {
        if (!$this->next) {
            return false;
        }

        return $this->next->isScheduledDate($date);
    }

    private function isValidSchedule(Schedule $delta)
    {
        if (get_class($delta) != get_class($this)) {
            throw new \InvalidArgumentException('Only schedules of the same type are allowed to be merged');
        }
    }
}

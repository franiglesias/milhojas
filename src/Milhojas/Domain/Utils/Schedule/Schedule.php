<?php

namespace Milhojas\Domain\Utils\Schedule;

abstract class Schedule
{
    protected $schedule;
    private $next;

    /**
     * {@inheritdoc}
     */
    abstract public function isScheduledDate(\DateTime $date);

     /**
      * {@inheritdoc}
      */
     public function update(Schedule $delta)
     {
         $updated = clone $this;
         $updated->schedule = array_merge($this->schedule, $delta->schedule);

         return $updated;
     }

    public function setNext(Schedule $nextSchedule)
    {
        if (!$this->next) {
            $this->next = $nextSchedule;

            return;
        }

        $this->next->setNext($nextSchedule);
    }

    protected function delegate(\DateTime $date)
    {
        if (!$this->next) {
            return false;
        }

        return $this->next->isScheduledDate($date);
    }
}

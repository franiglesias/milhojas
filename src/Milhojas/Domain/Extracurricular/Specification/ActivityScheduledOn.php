<?php

namespace Milhojas\Domain\Extracurricular\Specification;

use Milhojas\Domain\Extracurricular\Activity;

class ActivityScheduledOn implements ActivitySpecification
{
    private $date;

    /**
     * @param \DateTimeInterface $date
     */
    public function __construct($date)
    {
        $this->date = $date;
    }

    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy(Activity $activity)
    {
        return $activity->isScheduledFor($this->date);
    }
}

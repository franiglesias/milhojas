<?php

namespace Milhojas\Domain\Extracurricular;

use Milhojas\Domain\Extracurricular\Specification\ActivitySpecification;

class ActivitiesUser
{
    private $activities;

    public function __construct()
    {
        $this->activities = new \SplObjectStorage();
    }

    /**
     * Adds an Activity to the collection.
     *
     * @param Activity $activity
     */
    public function enrollTo(Activity $activity)
    {
        $this->activities->attach($activity);
    }

    /**
     * Tells if Activity is included in the list.
     *
     * @param string $activityName
     *
     * @return bool
     */
    public function isEnrolledTo(ActivitySpecification $specification)
    {
        foreach ($this->activities as $activity) {
            if ($specification->isSatisfiedBy($activity)) {
                return true;
            }
        }

        return false;
    }

    public function hasScheduledActivitiesOn(\DateTime $date)
    {
        foreach ($this->activities as $activity) {
            if ($activity->isScheduledFor($date)) {
                return true;
            }
        }

        return false;
    }

    public function disenrollFrom(Activity $activity)
    {
        $this->activities->detach($activity);
    }
}

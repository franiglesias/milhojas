<?php

namespace Milhojas\Infrastructure\Persistence\Extracurricular;

use Milhojas\Domain\Extracurricular\Activity;
use Milhojas\Domain\Extracurricular\ActivityRepository;
use Milhojas\Domain\Extracurricular\Specification\ActivitySpecification;

class ActivityInMemoryRepository implements ActivityRepository
{
    private $activities = [];
    public function store(Activity $activity)
    {
        $this->activities[] = $activity;
    }

    public function count()
    {
        return count($this->activities);
    }

    /**
     * {@inheritdoc}
     */
    public function get(ActivitySpecification $activitySpecification)
    {
        foreach ($this->activities as $activity) {
            if ($activitySpecification->isSatisfiedBy($activity)) {
                return $activity;
            }
        }
        throw new \RuntimeException('Activity not found!');
    }
}

<?php

namespace Milhojas\Domain\Extracurricular;

use Milhojas\Domain\Extracurricular\Specification\ActivitySpecification;

interface ActivityRepository
{
    /**
     * Add an activity to Repository.
     *
     * @param Activity $activity
     */
    public function store(Activity $activity);
    /**
     * @return int Count of activities in repository
     */
    public function count();

    public function get(ActivitySpecification $activitySpecification);
}

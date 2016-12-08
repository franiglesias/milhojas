<?php

namespace Milhojas\Domain\Extracurricular;

use Milhojas\Domain\Extracurricular\Specification\ActivityHasName;

class ExtracurricularManager
{
    private $activityRepository;

    public function __construct(ActivityRepository $activityRepository)
    {
        $this->activityRepository = $activityRepository;
    }

    public function enrollStudent(ActivitiesUser $student, $activityName)
    {
        $activity = $this->activityRepository->get(new ActivityHasName($activityName));
        $student->enrollTo($activity);
    }
}

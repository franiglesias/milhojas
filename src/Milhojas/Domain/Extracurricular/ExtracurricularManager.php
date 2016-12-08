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

    public function enrollUser(ActivitiesUser $user, $activityName)
    {
        $activity = $this->activityRepository->get(new ActivityHasName($activityName));
        $user->enrollTo($activity);
    }

    public function disenrollUser(ActivitiesUser $user, $activityName)
    {
        $activity = $this->activityRepository->get(new ActivityHasName($activityName));
        $user->disenrollFrom($activity);
    }
}

<?php

namespace Milhojas\Domain\Extracurricular;

use Milhojas\Domain\Extracurricular\Specification\ActivityHasName;
use Milhojas\Domain\School\Student;

class ExtracurricularManager
{
    private $activityRepository;
    public function __construct(ActivityRepository $activityRepository)
    {
        $this->activityRepository = $activityRepository;
    }

    public function enrollStudent(Student $student, $activityName)
    {
        $activity = $this->activityRepository->get(new ActivityHasName($activityName));
        $student->enrollToExtracurricular($activity);
    }
}

<?php

namespace Milhojas\Domain\Extracurricular;

use Milhojas\Domain\Extracurricular\Specification\ActivitiesUserSpecification;

interface ActivitiesUserRespository
{
    public function store(ActivitiesUser $activitiesUser);
    public function get(ActivitiesUserSpecification $activitiesUserSpecification);
}

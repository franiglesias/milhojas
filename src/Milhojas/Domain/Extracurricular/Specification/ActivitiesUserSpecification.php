<?php

namespace Milhojas\Domain\Extracurricular\Specification;

use Milhojas\Domain\Extracurricular\ActivitiesUser;

interface ActivitiesUserSpecification
{
    public function isSatisfiedBy(ActivitiesUser $activitiesUser);
}

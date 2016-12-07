<?php

namespace Milhojas\Domain\Extracurricular\Specification;

use Milhojas\Domain\Extracurricular\Activity;

interface ActivitySpecification
{
    public function isSatisfiedBy(Activity $activity);
}

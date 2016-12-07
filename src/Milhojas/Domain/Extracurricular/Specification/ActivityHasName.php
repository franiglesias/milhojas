<?php

namespace Milhojas\Domain\Extracurricular\Specification;

use Milhojas\Domain\Extracurricular\Activity;

class ActivityHasName implements ActivitySpecification
{
    private $name;
    /**
     * @param mixed $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function isSatisfiedBy(Activity $activity)
    {
        return $this->name == $activity->getName();
    }
}

<?php

namespace Milhojas\Domain\School;

use Milhojas\Domain\School\EducationStage;

/**
 * Represents an Education System defined by the Education Laws
 */
class EducationSystem
{
    /**
     * The name
     *
     * @return string
     */
    private $name;

    /**
     * A collection of EducationStages
     *
     * @var array
     */
    private $stages;

    public function __construct($education_system_name)
    {
        $this->name = $education_system_name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function equals(EducationSystem $system)
    {
        return $this->name == $system->getName();
    }

    public function addStage(EducationStage $stage)
    {
        $this->stages[] = $stage;
    }

    public function hasStages()
    {
        return count($this->stages);
    }
}

 ?>

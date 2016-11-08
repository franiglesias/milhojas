<?php

namespace Milhojas\Domain\School;

use Milhojas\Domain\School\EducationStage;
use Milhojas\Library\ValueObjects\Identity\Name;

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

    public function __construct(Name $education_system_name)
    {
        $this->name = $education_system_name;
    }

    public function getName()
    {
        return $this->name->get();
    }

    public function equals(EducationSystem $system)
    {
        return $this->getName() == $system->getName();
    }

    public function addStage($stage_name, $stage_short_name, $levels_in_stage)
    {
        $this->stages[] = new EducationStage($this, $stage_name, $stage_short_name, $levels_in_stage);
    }

    public function hasStages()
    {
        return count($this->stages);
    }
}

 ?>

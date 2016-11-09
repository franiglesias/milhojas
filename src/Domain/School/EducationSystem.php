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
     * @var \ArrayObject
     */
    private $stages;

    public function __construct(Name $education_system_name)
    {
        $this->name = $education_system_name;
        $this->stages = new \ArrayObject();
    }

    public function getName()
    {
        return $this->name->get();
    }

    public function equals(EducationSystem $system)
    {
        return $this->getName() == $system->getName();
    }

    public function addStage(Name $stage_name, Name $stage_short_name, $levels_in_stage)
    {
        $this->stages->offsetSet($stage_name->get(), new EducationStage($this, $stage_name, $stage_short_name, $levels_in_stage));
    }

    public function addSubject(Name $stage_short_name, Name $subject_name, $optional = false, $levels = [])
    {
        if ($this->stages->offsetExists($stage_short_name->get())) {
            $this->stages->offsetGet()
            ->addSubject($subject_name, $optional, $levels);
        }
    }

    public function hasStages()
    {
        return count($this->stages);
    }
}

 ?>

<?php

namespace Milhojas\Domain\School;

/**
 * Represents an Education System defined by the Education Laws
 */
class EducationSystem
{
    private $name;

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
}

 ?>

<?php

namespace Milhojas\Domain\Shared;

class ClassGroup
{
    private $name;
    private $shortName;
    private $stageName;

    public function __construct($name, $shortName, $stageName)
    {
        $this->name = $name;
        $this->shortName = $shortName;
        $this->stageName = $stageName;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getShortName()
    {
        return $this->shortName;
    }

    public function getStageName()
    {
        return $this->stageName;
    }

}

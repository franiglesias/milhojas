<?php

namespace Milhojas\Domain\Cantine;

class CantineGroup
{
    private $name;

    /**
     * @param mixed $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function isTheSameAs(CantineGroup $theOtherGroup)
    {
        return $this->name == $theOtherGroup->name;
    }
}

<?php

namespace Milhojas\Domain\Cantine;

class Turn
{
    private $name;
    private $order;

    public function __construct($name, $order)
    {
        $this->name = $name;
        $this->order = $order;
    }

    public function getName()
    {
        return $this->name;
    }
}

<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Library\Sortable\Sortable;

class Turn implements Sortable
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

    public function compare($other)
    {
        if ($this->order < $other->order) {
            return Sortable::SMALLER;
        }
        if ($this->order > $other->order) {
            return Sortable::GREATER;
        }

        return Sortable::EQUAL;
    }
}

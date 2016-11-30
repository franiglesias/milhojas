<?php

namespace Milhojas\Domain\Cantine\Factories;

use Milhojas\Domain\Cantine\Allergens;
use Milhojas\Library\Collections\Checklist;

class AllergensFactory
{
    private $supported;

    public function __construct()
    {
        $this->supported = [];
    }

    public function configure(array $supported)
    {
        $this->supported = $supported;
    }

    public function getBlankAllergensSheet()
    {
        return new Allergens(new Checklist($this->supported));
    }
}

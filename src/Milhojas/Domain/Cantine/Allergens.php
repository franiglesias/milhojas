<?php

namespace Milhojas\Domain\Cantine;
use Milhojas\Library\Collections\Checklist;

class Allergens extends Checklist
{
    public function __construct($allergens)
    {
        parent::__construct($allergens);
    }
    
}

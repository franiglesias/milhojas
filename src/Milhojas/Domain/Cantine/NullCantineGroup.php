<?php

namespace Milhojas\Domain\Cantine;

class NullCantineGroup extends CantineGroup
{
    public function __construct()
    {
        parent::__construct('Not Assigned');
    }
}

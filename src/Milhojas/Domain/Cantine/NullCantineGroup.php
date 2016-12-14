<?php

namespace Milhojas\Domain\Cantine;

/**
 * Represents a CantineGroup for NotAssigned students.
 */
class NullCantineGroup extends CantineGroup
{
    public function __construct()
    {
        parent::__construct('Not Assigned');
    }
}

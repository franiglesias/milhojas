<?php

namespace Milhojas\Domain\Cantine;

class NullTurn extends Turn
{
    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct('Not assigned', -1);
    }
}

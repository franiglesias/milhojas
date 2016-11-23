<?php

namespace Milhojas\Domain\School;

class NewStudentGroup extends StudentGroup
{
    public function __construct()
    {
        parent::__construct('New Students');
    }
}

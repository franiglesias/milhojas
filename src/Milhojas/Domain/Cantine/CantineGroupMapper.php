<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Domain\School\Student;

class CantineGroupMapper
{
    public function getGroup(Student $student)
    {
        $class = $student->getGroup();

        return $this->map[$class->getName()];
    }
}

<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Domain\School\Student;
use Milhojas\Domain\School\StudentGroup;
use Symfony\Component\Yaml\Yaml;

class CantineGroupMapper
{
    private $map;

    public function __construct($file)
    {
        $map = Yaml::parse(file_get_contents($file));
        foreach ($map['class_cantine_map'] as $class => $cantineGroupName) {
            $this->map[$class] = new CantineGroup($cantineGroupName);
        }
    }

    public function getGroupForStudent(Student $student)
    {
        $class = $student->getGroup();

        return $this->map[$class->getName()];
    }

    public function getMapFor(StudentGroup $studentGroup)
    {
        return $this->map[$studentGroup->getName()];
    }
}

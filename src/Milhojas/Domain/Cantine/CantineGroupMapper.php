<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Domain\School\Student;
use Milhojas\Domain\School\StudentGroup;
use Symfony\Component\Yaml\Yaml;

/**
 * Maps class Student Groups to Cantine Groups
 */
class CantineGroupMapper
{
    private $map;

    public function __construct()
    {
        $this->map = [];
    }

    public static function load($file)
    {
        $cantineGroupMapper = new CantineGroupMapper();

        $map = Yaml::parse(file_get_contents($file));
        foreach ($map['class_cantine_map'] as $class => $cantineGroupName) {
            $cantineGroupMapper->map[$class] = new CantineGroup($cantineGroupName);
        }
        return $cantineGroupMapper;
    }

    public function getCantineGroupForStudent(Student $student)
    {
        $class = $student->getGroup();

        return $this->map[$class->getName()];
    }

    public function getCantineGroupForClassGroup(StudentGroup $studentGroup)
    {
        return $this->map[$studentGroup->getName()];
    }

}

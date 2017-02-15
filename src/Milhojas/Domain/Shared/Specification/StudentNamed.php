<?php

namespace Milhojas\Domain\Shared\Specification;

use Milhojas\Domain\Shared\Student;
use RulerZ\Spec\AbstractSpecification;

class StudentNamed extends AbstractSpecification
{
    private $name;
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function isSatisfiedBy(Student $student)
    {
        return $this->name == $student->getPerson()->getFullName();
    }

    public function getRule()
    {
        return 'fullname = ":name"';
    }

    public function getParameters()
    {
        return ['name' => $this->name];
    }
}

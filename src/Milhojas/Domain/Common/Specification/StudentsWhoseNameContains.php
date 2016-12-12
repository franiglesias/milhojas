<?php

namespace Milhojas\Domain\Common\Specification;

use Milhojas\Domain\Common\Student;

class StudentsWhoseNameContains implements StudentServiceSpecification
{
    private $fragment;
    public function __construct($fragment)
    {
        $this->fragment = $fragment;
    }

    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy(Student $student)
    {
        $name = $student->getPerson()->getFullName();
        if (mb_stripos($name, $this->fragment) !== false) {
            return true;
        }

        return false;
    }
}

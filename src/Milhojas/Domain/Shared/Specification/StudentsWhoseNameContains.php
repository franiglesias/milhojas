<?php

namespace Milhojas\Domain\Shared\Specification;

use Milhojas\Domain\Shared\Student;
use RulerZ\Spec\Specification;

class StudentsWhoseNameContains implements Specification
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
    /**
     * {@inheritdoc}
     */
    public function getRule()
    {
        throw new \LogicException('Not implemented'); // TODO
    }

    /**
     * {@inheritdoc}
     */
    public function getParameters()
    {
        return ['fragment' => $this->fragment]; // TODO
    }
}

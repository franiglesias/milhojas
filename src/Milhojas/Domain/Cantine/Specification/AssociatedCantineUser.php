<?php

namespace Milhojas\Domain\Cantine\Specification;

use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Shared\Student;

/**
 * The cantine user that represents this Student.
 */
class AssociatedCantineUser implements CantineUserSpecification
{
    private $student;

    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy(CantineUser $cantineUser)
    {
        return $cantineUser->getStudentId() == $this->student->getId();
    }
}

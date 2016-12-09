<?php

namespace spec\Milhojas\Domain\Common\Specification;

use Milhojas\Domain\Common\Specification\StudentNamed;
use Milhojas\Domain\Common\Student;
use PhpSpec\ObjectBehavior;

class StudentNamedSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('Pedro Pérez');
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(StudentNamed::class);
    }

    public function it_should_be_satisfied_by(Student $student)
    {
        $student->getFullName()->willReturn('Pedro Pérez');
        $this->shouldBeSatisfiedBy($student);
    }
}

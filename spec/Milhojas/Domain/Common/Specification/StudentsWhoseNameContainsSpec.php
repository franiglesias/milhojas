<?php

namespace spec\Milhojas\Domain\Common\Specification;

use Milhojas\Domain\Common\Specification\StudentsWhoseNameContains;
use Milhojas\Domain\Common\Student;
use Milhojas\LIbrary\ValueObjects\Identity\Person;
use PhpSpec\ObjectBehavior;

class StudentsWhoseNameContainsSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('Álv');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(StudentsWhoseNameContains::class);
    }

    public function it_should_be_satisfied_by(Student $student, Person $person)
    {
        $person->getFullName()->willReturn('Lucía Álvarez');
        $student->getPerson()->willReturn($person);
        $this->shouldBeSatisfiedBy($student);
    }

    public function it_should_be_satisfied_by_student_whose_name_starts_with_fragment(Student $student, Person $person)
    {
        $person->getFullName()->willReturn('Álvaro Martínez');
        $student->getPerson()->willReturn($person);
        $this->shouldBeSatisfiedBy($student);
    }
}

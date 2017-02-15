<?php

namespace spec\Milhojas\Domain\Shared\Specification;

use Milhojas\Domain\Shared\Specification\StudentNamed;
use Milhojas\Domain\Shared\Student;
use Milhojas\Library\ValueObjects\Identity\Person;
use PhpSpec\ObjectBehavior;
use RulerZ\Spec\AbstractSpecification;

class StudentNamedSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('Pedro Pérez');
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(StudentNamed::class);
        $this->shouldBeAnInstanceOf(AbstractSpecification::class);
    }

    public function it_should_be_satisfied_by(Student $student, Person $person)
    {
        $person->getFullName()->willReturn('Pedro Pérez');
        $student->getPerson()->willReturn($person);
        $this->shouldBeSatisfiedBy($student);
    }

    public function it_returns_parameters()
    {
        $this->getParameters()->shouldBe(['name' => 'Pedro Pérez']);
    }
}

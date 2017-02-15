<?php

namespace spec\Milhojas\Infrastructure\Persistence\Shared;

use Milhojas\Domain\Shared\Exception\StudentServiceException;
use Milhojas\Infrastructure\Persistence\Shared\StudentServiceInMemoryRepository;
use Milhojas\Domain\Shared\StudentServiceRepository;
use RulerZ\Spec\Specification;
use Milhojas\Domain\Shared\Student;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StudentServiceInMemoryRepositorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(StudentServiceInMemoryRepository::class);
        $this->shouldImplement(StudentServiceRepository::class);
    }

    public function it_can_store_students(Student $student)
    {
        $this->store($student);
    }

    public function it_can_get_an_student_using_a_specification(Specification $specification, Student $student)
    {
        $this->store($student);

        $specification->isSatisfiedBy($student)->willReturn(true);
        $this->get($specification)->shouldHaveType(Student::class);
        $this->get($specification)->shouldBeLike($student);
    }

    public function it_can_find_students_satisfyind_specification(Specification $specification, Student $student, Student $student2, Student $student3)
    {
        $this->store($student);
        $this->store($student2);
        $this->store($student3);
        $specification->isSatisfiedBy($student)->willReturn(true);
        $specification->isSatisfiedBy($student2)->willReturn(false);
        $specification->isSatisfiedBy($student3)->willReturn(true);
        $this->find($specification)->shouldBeLike([$student, $student3]);
    }

    public function it_returns_empty_if_no_students_satisfiy_specifications(Specification $specification, Student $student, Student $student2, Student $student3)
    {
        $this->store($student);
        $this->store($student2);
        $this->store($student3);
        $specification->isSatisfiedBy($student)->willReturn(false);
        $specification->isSatisfiedBy($student2)->willReturn(false);
        $specification->isSatisfiedBy($student3)->willReturn(false);
        $this->find($specification)->shouldBeLike([]);
    }

    public function it_throws_exception_if_student_not_found(Specification $specification)
    {
        $specification->isSatisfiedBy(Argument::type(Student::class))->willReturn(false);
        $this->shouldThrow(StudentServiceException::class)->during('get', [$specification]);
    }
}

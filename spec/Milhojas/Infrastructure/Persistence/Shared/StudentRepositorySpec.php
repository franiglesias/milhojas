<?php

namespace spec\Milhojas\Infrastructure\Persistence\Shared;

use Milhojas\Infrastructure\Persistence\Shared\StudentRepository;
use Milhojas\Infrastructure\Persistence\Storage\Storage;
use Milhojas\Domain\Shared\Student;
use Milhojas\Domain\Shared\StudentServiceRepository;
use Milhojas\Domain\Shared\Specification\StudentServiceSpecification;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StudentRepositorySpec extends ObjectBehavior
{
    public function let(Storage $storage)
    {
        $this->beConstructedWith($storage);
        $this->shouldImplement(StudentServiceRepository::class);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(StudentRepository::class);
    }

    public function it_can_store_Students(Student $student, $storage)
    {
        $storage->store($student)->shouldBeCalled();
        $this->store($student);
    }

    public function it_can_find_students(StudentServiceSpecification $specification, Student $student, $storage)
    {
        $storage->findBy(Argument::any())->willReturn([$student]);
        $specification->isSatisfiedBy($student)->shouldBeCalled(1)->willReturn(true);
        $this->find($specification)->shouldBe([$student]);
    }

    public function it_can_get_student(StudentServiceSpecification $specification, Student $student, $storage)
    {
        $storage->findBy(Argument::any())->willReturn([$student]);
        $specification->isSatisfiedBy($student)->shouldBeCalled(1)->willReturn(true);

        $this->get($specification)->shouldBe($student);
    }
}

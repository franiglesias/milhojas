<?php

namespace spec\Milhojas\Infrastructure\Persistence\Shared;

use Milhojas\Infrastructure\Persistence\Shared\StudentRepository;
use Milhojas\Infrastructure\Persistence\Shared\Mapper\StudentMapper;
use Milhojas\Infrastructure\Persistence\Shared\DTO\StudentDTO;
use Milhojas\Infrastructure\Persistence\Storage\Storage;
use Milhojas\Domain\Shared\Student;
use Milhojas\Domain\Shared\StudentServiceRepository;
use Milhojas\Domain\Shared\Specification\StudentServiceSpecification;
use PhpSpec\ObjectBehavior;

class StudentRepositorySpec extends ObjectBehavior
{
    public function let(Storage $storage, StudentMapper $mapper)
    {
        $this->beConstructedWith($storage, $mapper);
        $this->shouldImplement(StudentServiceRepository::class);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(StudentRepository::class);
    }

    public function it_can_store_Students(Student $student, $storage, $mapper, StudentDTO $dto)
    {
        $mapper->toDto($student)->shouldBeCalled()->willReturn($dto);
        $storage->store($dto)->shouldBeCalled()->willReturn($dto);
        $this->store($student);
    }

    public function it_can_find_students(StudentServiceSpecification $specification, Student $student, StudentDTO $dto, $storage, $mapper)
    {
        $storage->findAll()->willReturn([$dto]);
        $mapper->toEntity($dto)->shouldBeCalled()->willReturn($student);
        $specification->isSatisfiedBy($student)->shouldBeCalled(1)->willReturn(true);
        $this->find($specification)->shouldBe([$student]);
    }
}

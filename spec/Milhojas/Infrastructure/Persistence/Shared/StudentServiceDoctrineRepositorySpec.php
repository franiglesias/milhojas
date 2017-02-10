<?php

namespace spec\Milhojas\Infrastructure\Persistence\Shared;

use Milhojas\Infrastructure\Persistence\Shared\StudentServiceDoctrineRepository;
use Milhojas\Infrastructure\Persistence\Shared\Mapper\StudentMapper;
use Milhojas\Infrastructure\Persistence\Shared\DTO\StudentDTO;
use Milhojas\Domain\Shared\Student;
use Milhojas\Domain\Shared\StudentServiceRepository;
use PhpSpec\ObjectBehavior;
use Doctrine\ORM\EntityManagerInterface;
use Prophecy\Argument;

class StudentServiceDoctrineRepositorySpec extends ObjectBehavior
{
    public function let(EntityManagerInterface $entityManager, StudentMapper $mapper)
    {
        $this->beConstructedWith($entityManager, $mapper);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(StudentServiceDoctrineRepository::class);
        $this->shouldImplement(StudentServiceRepository::class);
    }

    public function it_can_store_Students(Student $student, StudentDTO $studentDTO, $entityManager, $mapper)
    {
        $mapper->entityToDto($student)->willReturn($studentDTO);
        $entityManager->persist(Argument::type(StudentDTO::class))->shouldBeCalled();
        $entityManager->flush()->shouldBeCalled();
        $this->store($student);
    }
}

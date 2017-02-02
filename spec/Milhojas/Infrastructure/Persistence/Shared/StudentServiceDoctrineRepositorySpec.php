<?php

namespace spec\Milhojas\Infrastructure\Persistence\Shared;

use Milhojas\Infrastructure\Persistence\Shared\StudentServiceDoctrineRepository;
use Milhojas\Domain\Shared\Student;
use Milhojas\Domain\Shared\StudentId;
use Milhojas\Domain\Shared\StudentServiceRepository;
use Milhojas\Application\Shared\DTO\StudentDTO;
use Milhojas\Library\ValueObjects\Identity\Person;
use PhpSpec\ObjectBehavior;
use Doctrine\ORM\EntityManagerInterface;
use Prophecy\Argument;

class StudentServiceDoctrineRepositorySpec extends ObjectBehavior
{
    public function let(EntityManagerInterface $entityManager)
    {
        $this->beConstructedWith($entityManager);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(StudentServiceDoctrineRepository::class);
        $this->shouldImplement(StudentServiceRepository::class);
    }

    public function it_can_store_Students(Student $student, Person $person, $entityManager)
    {
        $student->getPerson()->willReturn($person);
        $student->getId()->willReturn(StudentId::generate());
        $entityManager->persist(Argument::type(StudentDTO::class))->shouldBeCalled();
        $entityManager->flush()->shouldBeCalled();
        $this->store($student);
    }
}

<?php

namespace spec\Milhojas\Infrastructure\Persistence\Shared\Mapper;

use Milhojas\Infrastructure\Persistence\Shared\Mapper\StudentMapper;
use Milhojas\Infrastructure\Persistence\Shared\DTO\PersonDTO;
use Milhojas\Infrastructure\Persistence\Shared\DTO\StudentDTO;
use Milhojas\Domain\Shared\Student;
use Milhojas\Domain\Shared\StudentId;
use Milhojas\Library\ValueObjects\Identity\Person;
use PhpSpec\ObjectBehavior;

class StudentMapperSpec extends ObjectBehavior
{
    public function let()
    {
        $from = function (Student $student) {
            return StudentDTO::fromStudent($student);
        };
        $to = function (StudentDTO $dto) {
            $person = $dto->getPerson();

            return new Student(
                new StudentId($dto->getId()),
                new Person($person->getName(), $person->getSurname(), $person->getGender()),
                '',
                ''
            );
        };
        $this->beConstructedWith($from, $to);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(StudentMapper::class);
    }

    public function it_maps_domain_entity_to_dto(Student $student)
    {
        $student->getPlainId()->willReturn('id');
        $student->getPerson()->willReturn(new Person('Name', 'Surname', 'male'));
        $dto = new StudentDTO();
        $dto->setId('id');
        $dto->setPerson(new PersonDTO('Name', 'Surname', 'male'));
        $this->entityToDto($student)->shouldBeLike($dto);
    }

    public function it_maps_dto_to_domain_entity(StudentDTO $dto)
    {
        $student = new Student(new StudentId('id'), new Person('Name', 'Surname', 'male'), '', '');
        $dto->getId()->willReturn('id');
        $dto->getPerson()->willReturn(new PersonDTO('Name', 'Surname', 'male'));
        $this->dtoToEntity($dto)->shouldBeLike($student);
    }
}

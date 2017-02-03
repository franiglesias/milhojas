<?php

namespace Milhojas\Infrastructure\Persistence\Shared\Mapper;

use Milhojas\Domain\Shared\Student;
use Milhojas\Domain\Shared\StudentId;
use Milhojas\Infrastructure\Persistence\Shared\DTO\StudentDTO;
use Milhojas\Library\ValueObjects\Identity\Person;

class StudentMapper
{
    public function toDto(Student $student)
    {
        return StudentDTO::fromStudent($student);
    }

    public function toEntity(StudentDTO $dto)
    {
        $person = $dto->getPerson();

        return new Student(
            new StudentId($dto->getId()),
            new Person($person->getName(), $person->getSurname(), $person->getGender()),
            '',
            ''
        );
    }
}

<?php

namespace Milhojas\Infrastructure\Persistence\Shared\DTO;

use Doctrine\ORM\Mapping as ORM;
use Milhojas\Library\ValueObjects\Identity\Person;
use Milhojas\Domain\Shared\Student;
use Milhojas\Domain\Shared\StudentId;

/**
 * @ORM\Entity
 * @ORM\Table(name="enrolled_students")
 */
class StudentDTO
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $id;
    /**
     * @ORM\Embedded(class="PersonDTO")
     *
     * @var Person
     */
    private $person;

    public static function init()
    {
        $dto = new static();
        $dto->person = new PersonDTO('', '', '');

        return $dto;
    }

    public static function fromStudent(Student $student)
    {
        $dto = new static();
        $dto->person = PersonDTO::fromPerson($student->getPerson());
        $dto->id = $student->getPlainId();

        return $dto;
    }
    /**
     * @return StudentId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param StudentId $id
     *
     * @return static
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getPerson()
    {
        return $this->person;
    }

    public function setPerson($person)
    {
        $this->person = $person;
    }

    public function getName()
    {
        return $this->person->getName();
    }

    public function getSurname()
    {
        return $this->person->getSurname();
    }

    public function getGender()
    {
        return $this->person->getGender();
    }
}

<?php

namespace Milhojas\Application\Shared;

use Milhojas\Library\ValueObjects\Identity\Person;

class StudentDTO
{
    private $person;

    public static function init()
    {
        $dto = new static();
        $dto->person = new Person('', '', '');

        return $dto;
    }

    public function getPerson()
    {
        return $this->person;
    }

    public function setPerson(Person $person)
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

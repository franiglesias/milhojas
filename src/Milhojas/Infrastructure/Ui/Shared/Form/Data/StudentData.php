<?php

namespace Milhojas\Infrastructure\Ui\Shared\Form\Data;

class StudentData
{
    /**
     * @var PersonData
     */
    private $person;

    public function getPerson()
    {
        return $this->person;
    }

    public function setPerson(PersonData $person)
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

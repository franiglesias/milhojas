<?php

namespace Milhojas\Application\Shared\Command;

use Milhojas\Messaging\CommandBus\Command;
use Milhojas\Library\ValueObjects\Identity\Person;

class EnrollStudent implements Command
{
    /**
     * @var Person
     */
    private $person;

    /**
     * @param Person $person
     */
    public function __construct(Person $person)
    {
        $this->person = $person;
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

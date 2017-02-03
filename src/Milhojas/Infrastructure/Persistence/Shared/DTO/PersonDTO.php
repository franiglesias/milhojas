<?php

namespace Milhojas\Infrastructure\Persistence\Shared\DTO;

use Doctrine\ORM\Mapping as ORM;
use Milhojas\Library\ValueObjects\Identity\Person;

/**
 * @ORM\Embeddable
 */
class PersonDTO
{
    /**
     * @ORM\Column(type="string")
     *
     * @var mixed
     */
    private $name;
    /**
     * @ORM\Column(type="string")
     *
     * @var mixed
     */
    private $surname;
    /**
     * @ORM\Column(type="string")
     *
     * @var mixed
     */
    private $gender;

    /**
     * @param mixed $name
     * @param mixed $surname
     * @param mixed $gender
     */
    public function __construct($name, $surname, $gender)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->gender = $gender;
    }

    public static function fromPerson(Person $person)
    {
        return new self($person->getName(), $person->getSurname(), $person->getGender());
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return static
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     *
     * @return static
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     *
     * @return static
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }
}

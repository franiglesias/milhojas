<?php

namespace Milhojas\Application\Shared\DTO;

use Doctrine\ORM\Mapping as ORM;

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

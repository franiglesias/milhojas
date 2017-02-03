<?php

namespace Milhojas\Infrastructure\Ui\Shared\Form\Data;

class PersonData
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $surname;
    /**
     * @var string
     */
    private $gender;

    /**
     * @param string $name
     * @param string $surname
     * @param string $gender
     */
    public function __construct($name = '', $surname = '', $gender = '')
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->gender = $gender;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }
}

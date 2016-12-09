<?php

namespace Milhojas\Domain\Common;

class Student
{
    private $id;
    private $name;
    private $surname;
    private $class;
    private $remarks;

    /**
     * @param mixed $id
     * @param mixed $name
     * @param mixed $surname
     * @param mixed $class
     * @param mixed $remarks
     */
    public function __construct($id, $name, $surname, $class, $remarks)
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->class = $class;
        $this->remarks = $remarks;
    }
    /**
     * @return
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param  $id
     *
     * @return static
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param  $name
     *
     * @return static
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param  $surname
     *
     * @return static
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * @return
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param  $class
     *
     * @return static
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @return
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * @param  $remarks
     *
     * @return static
     */
    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;

        return $this;
    }

    public function getFullName()
    {
        return sprintf('%s %s', $this->name, $this->surname);
    }

    public function getAllergies()
    {
        return null;
    }
}

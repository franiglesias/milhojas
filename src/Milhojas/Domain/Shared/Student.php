<?php

namespace Milhojas\Domain\Shared;

class Student
{
    private $id;
    private $person;

    private $class;
    private $remarks;

    private $allergies;

    public function __construct($id, $person, $class, $remarks)
    {
        $this->id = $id;
        $this->person = $person;
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
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * @param  $person
     *
     * @return static
     */
    public function setPerson($person)
    {
        $this->person = $person;
        return $this;
    }/**
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

    public function getAllergies()
    {
        return null;
    }

    public function getLabel()
    {
        $format = '%s (%s)';
        return sprintf($format, $this->person->getFullName(), $this->class);
    }
}

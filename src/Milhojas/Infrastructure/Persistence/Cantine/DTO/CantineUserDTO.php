<?php

namespace Milhojas\Infrastructure\Persistence\Cantine\DTO;

class CantineUserDTO
{
    protected $studentId;
    protected $person;
    protected $schedule;
    protected $allergens;
    protected $cantineGroup;
    protected $classGroup;
    protected $remarks;

    /**
     * @return
     */
    public function getStudentId()
    {
        return $this->studentId;
    }

    /**
     * @param  $studentId
     *
     * @return static
     */
    public function setStudentId($studentId)
    {
        $this->studentId = $studentId;

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
    }

    /**
     * @return
     */
    public function getSchedule()
    {
        return $this->schedule;
    }

    /**
     * @param  $schedule
     *
     * @return static
     */
    public function setSchedule($schedule)
    {
        $this->schedule = $schedule;

        return $this;
    }

    /**
     * @return
     */
    public function getAllergens()
    {
        return $this->allergens;
    }

    /**
     * @param  $allergens
     *
     * @return static
     */
    public function setAllergens($allergens)
    {
        $this->allergens = $allergens;

        return $this;
    }

    /**
     * @return
     */
    public function getCantineGroup()
    {
        return $this->cantineGroup;
    }

    /**
     * @param  $cantineGroup
     *
     * @return static
     */
    public function setCantineGroup($cantineGroup)
    {
        $this->cantineGroup = $cantineGroup;

        return $this;
    }

    /**
     * @return
     */
    public function getClassGroup()
    {
        return $this->classGroup;
    }

    /**
     * @param  $classGroup
     *
     * @return static
     */
    public function setClassGroup($classGroup)
    {
        $this->classGroup = $classGroup;

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
}

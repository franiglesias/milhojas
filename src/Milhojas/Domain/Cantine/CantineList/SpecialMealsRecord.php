<?php

namespace Milhojas\Domain\Cantine\CantineList;

/**
 * DTO to generate Special Meals Reports.
 */
class SpecialMealsRecord
{
    /**
     * @var string
     */
    private $turn;
    /**
     * @var string
     */
    private $student;
    /**
     * @var string
     */
    private $remarks;
    /**
     * @param mixed $turn
     * @param mixed $student
     * @param mixed $remarks
     */
    public function __construct($turn, $student, $remarks)
    {
        $this->turn = $turn;
        $this->student = $student;
        $this->remarks = $remarks;
    }
    /**
     * @return string
     */
    public function getTurn()
    {
        return $this->turn;
    }

    /**
     * @return string
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * @return string
     */
    public function getRemarks()
    {
        return $this->remarks;
    }
}

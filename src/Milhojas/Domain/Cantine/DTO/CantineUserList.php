<?php

namespace Milhojas\Domain\Cantine\DTO;

/**
 * @ORM\Entity
 * @ORM\Table(name="cantine_user_list")
 */
class CantineUserList
{
    /**
     * @ORM\Column(type="datetime")
     */
    private $date;
    /**
     * @ORM\Column(type="string")
     */
    private $turn;
    /**
     * @ORM\Column(type="string")
     */
    private $studentId;
    /**
     * @ORM/Column(type="string")
     */
    private $name;
    /**
     * @ORM/Column/type="string"
     */
    private $remarks;
    /**
     * @param mixed $date
     * @param mixed $turn
     * @param mixed $studentId
     * @param mixed $name
     * @param mixed $remarks
     */
    public function __construct($date, $turn, $studentId, $name, $remarks)
    {
        $this->date = $date;
        $this->turn = $turn;
        $this->studentId = $studentId;
        $this->name = $name;
        $this->remarks = $remarks;
    }

    /**
     * @return
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param  $date
     *
     * @return static
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return
     */
    public function getTurn()
    {
        return $this->turn;
    }

    /**
     * @param  $turn
     *
     * @return static
     */
    public function setTurn($turn)
    {
        $this->turn = $turn;

        return $this;
    }

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

<?php

namespace Milhojas\Domain\Shared;

/**
 * Identifies an student.
 */
class StudentId
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
    /**
     * @return
     */
    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->id;
    }
}
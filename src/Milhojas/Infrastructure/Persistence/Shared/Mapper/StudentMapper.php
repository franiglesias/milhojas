<?php

namespace Milhojas\Infrastructure\Persistence\Shared\Mapper;

use Milhojas\Infrastructure\Persistence\Mapper\Mapper;

class StudentMapper implements Mapper
{
    private $from;
    private $to;
    public function __construct(\Closure $from, \Closure $to)
    {
        $this->from = $from;
        $this->to = $to;
    }
    public function entityToDto($student)
    {
        if (is_array($student)) {
            return array_map($this->from, $student);
        }

        return $this->from->__invoke($student);
    }

    public function dtoToEntity($dto)
    {
        if (is_array($dto)) {
            return array_map($this->to, $dto);
        }

        return $this->to->__invoke($dto);
    }
}

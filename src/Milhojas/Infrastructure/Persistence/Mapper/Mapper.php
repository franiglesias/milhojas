<?php

namespace Milhojas\Infrastructure\Persistence\Mapper;

interface Mapper
{
    public function toDTO($argument1);

    public function toEntity($argument1);

    public function fromDTO($argument1);
}

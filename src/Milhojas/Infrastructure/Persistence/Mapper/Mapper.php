<?php

namespace Milhojas\Infrastructure\Persistence\Mapper;

interface Mapper
{
    public function dtoToEntity($dto);
    public function entityToDto($entity);
}

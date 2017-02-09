<?php

namespace Milhojas\Infrastructure\Persistence\Storage;

interface Storage
{
    public function store($argument1);

    public function findAll();
}

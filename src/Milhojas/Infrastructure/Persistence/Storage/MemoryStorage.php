<?php

namespace Milhojas\Infrastructure\Persistence\Storage;

class MemoryStorage implements Storage
{
    private $collection;

    public function __construct()
    {
        $this->collection = new \SplObjectStorage();
    }
    /**
     * {@inheritdoc}
     */
    public function store($object)
    {
        $this->collection->attach($object);
    }

    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        return $this->collection;
    }
    /**
     * {@inheritdoc}
     */
    public function findBy($argument1)
    {
        throw new \LogicException('Not implemented'); // TODO
    }
}

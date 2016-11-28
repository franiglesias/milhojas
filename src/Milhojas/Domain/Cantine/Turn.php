<?php

namespace Milhojas\Domain\Cantine;

class Turn implements \IteratorAggregate, \ArrayAccess, \Countable
{
    private $name;
    private $order;
    private $users;

    public function __construct($name, $order)
    {
        $this->name = $name;
        $this->order = $order;
    }

    public function getName()
    {
        return $this->name;
    }

    public function isLessThan(Turn $turn)
    {
        return $this->order < $turn->order;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->users);
    }

    public function appoint(CantineUser $User)
    {
        $this->users[] = $User;
    }

    public function count()
    {
        return count($this->users);
    }

    public function sort()
    {
        @usort($this->users, function (CantineUser $a, CantineUser $b) {
            return $a->compare($b);
        });
    }
    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return isset($this->users[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->users[$offset];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->users[$offset] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->users[$offset]);
    }
}

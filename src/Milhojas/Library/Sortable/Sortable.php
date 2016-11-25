<?php

namespace Milhojas\Library\Sortable;

interface Sortable
{
    const GREATER = 1;
    const EQUAL = 0;
    const SMALLER = -1;
    /**
     * Compares current instance with another object.
     *
     * @param mixed $object
     *
     * @return int -1 $this is lesser than $object
     * @return int 0 is they are equal
     * @return int +1 $this is greater than $object
     */
    public function compare($object);
}

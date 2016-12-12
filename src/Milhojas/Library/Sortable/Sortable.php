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
     * @return int -1|self::SMALLER $this is smaller than $object
     * @return int 0|self::EQUAL is they are equal
     * @return int +1|self::GREATER $this is greater than $object
     */
    public function compare($object);
}

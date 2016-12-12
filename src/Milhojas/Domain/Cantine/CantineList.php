<?php

namespace Milhojas\Domain\Cantine;

/**
 * Represents the list of CantineUsers eating on a date, assigned to a Turn
 * The list is ordered by Turn and User List Name.
 */
class CantineList extends \SplMinHeap
{
    private $date;
    /**
     * @param DateTime $date
     */
    public function __construct(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * {@inheritdoc}
     */
    protected function compare($a, $b)
    {
        return -1 * $a->compare($b);
    }

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}

<?php

namespace Milhojas\Domain\Cantine\CantineList;
use Milhojas\Domain\Cantine\CantineList\CantineListReporter;

/**
 * Represents the list of CantineUsers eating on a date, assigned to a Turn
 * The list is ordered by Turn and User List Name.
 */
class CantineList extends \SplMinHeap
{
    private $date;
    /**
     * @param DateTimeInterface $date
     */
    public function __construct(\DateTimeInterface $date)
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

    public function accept(CantineListReporter $cantineListReporter)
    {
        $cantineListReporter->visitCantineList($this);
    }
}

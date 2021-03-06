<?php

namespace Milhojas\Domain\Cantine\CantineList;

/**
 * Represents the list of CantineUsers eating on a date, assigned to a Turn
 * The list is ordered by Turn and User List Name.
 */
class CantineList extends \SplMinHeap
{
    /**
     * {@inheritdoc}
     */
    protected function compare($a, $b)
    {
        return -1 * $a->compare($b);
    }

    /**
     * Accepts a CantineSeatListReporter visitor to generate reports about the list itself.
     *
     * @param CantineSeatListReporter $cantineListReporter
     */
    public function accept(CantineSeatListReporter $cantineListReporter)
    {
        foreach ($this as $record) {
            $record->accept($cantineListReporter);
        }
    }
}

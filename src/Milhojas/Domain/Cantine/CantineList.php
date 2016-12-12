<?php

namespace Milhojas\Domain\Cantine;

class CantineList extends \SplMinHeap
{
    private $date;
    /**
     * @param mixed $date
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

    public function getDate()
    {
        return $this->date;
    }
}

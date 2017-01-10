<?php

namespace Milhojas\Application\Cantine\Query;

use Milhojas\Library\QueryBus\Query;

/**
 * Transport data to generate a list of cantine users.
 */
class GetCantineAttendancesListFor implements Query
{
    /**
     * The date to generate the list.
     *
     * @var \DateTimeInterface
     */
    private $date;

    public function __construct(\DateTimeInterface $date)
    {
        $this->date = $date;
    }

    public function getDate()
    {
        return $this->date;
    }
}

<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Library\Sortable\Sortable;

/**
 * A Data Transport Object to hold the representation of a Cantine User in a CantineList.
 */
class CantineListRecord implements Sortable
{
    private $date;
    private $turn;
    private $cantineUser;
    public function __construct($date, Turn $turn, CantineUser $cantineUser)
    {
        $this->date = $date;
        $this->turn = $turn;
        $this->cantineUser = $cantineUser;
    }

    /**
     * {@inheritdoc}
     */
    public function compare($object)
    {
        $compareTurns = $this->turn->compare($object->getTurn());
        if ($compareTurns != Sortable::EQUAL) {
            return $compareTurns;
        }

        return $this->cantineUser->compare($object->getUser());
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getTurn()
    {
        return $this->turn;
    }

    public function getUser()
    {
        return $this->cantineUser;
    }
}
<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Library\Sortable\Sortable;

/**
 * A Data Transport Object to hold the representation of a Cantine User in a CantineList.
 */
class CantineListUserRecord implements Sortable
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

    public static function createFromUserTurnAndDate(CantineUser $cantineUser, Turn $turn, \DateTimeInterface $date)
    {
        $cantineListUserRecord = new CantineListUserRecord($date, $turn, $cantineUser);
        return $cantineListUserRecord;
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

    public function getTurnName()
    {
        return $this->turn->getName();
    }

    public function getUserListName()
    {
        return $this->cantineUser->getListName();
    }

    public function getClassGroupName()
    {
        return $this->cantineUser->getClassGroupName();
    }

    public function getStageName()
    {
        return $this->cantineUser->getStageName();
    }

    public function getRemarks()
    {
        return $this->cantineUser->getRemarks();
    }
}

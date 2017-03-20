<?php

namespace Milhojas\Domain\Cantine\CantineList;

use Milhojas\Library\Sortable\Sortable;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\Turn;

/**
 * Represents the assginement of a student to a seat in the Cantine for a given date.
 */
class CantineSeat implements Sortable
{
    private $date;
    private $turn;
    private $user;

    /**
     * @param mixed       $date
     * @param mixed       $turn
     * @param CantineUser $user
     */
    public function __construct(
        $date,
        $turn,
        $user
    ) {
        $this->date = $date;
        $this->turn = $turn;
        $this->user = $user;
    }

    /**
     * @param CantineUser        $user
     * @param Turn               $turn
     * @param \DateTimeInterface $date
     */
    public static function createFromUserTurnAndDate(CantineUser $user, Turn $turn, \DateTimeInterface $date)
    {
        return new self($date, $turn, $user);
    }

    /**
     * {@inheritdoc}
     */
    public function compare($seat)
    {
        $compareTurns = $this->turn->compare($seat->getTurn());
        if ($compareTurns != Sortable::EQUAL) {
            return $compareTurns;
        }

        return $this->user->compare($seat->getUser());
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
        return $this->user;
    }

    public function getTurnName()
    {
        return $this->turn->getName();
    }

    public function getUserListName()
    {
        return $this->user->getListName();
    }

    public function getClassGroupName()
    {
        return $this->user->getClassGroupName();
    }

    public function getStageName()
    {
        return $this->user->getStageName();
    }

    public function getRemarks()
    {
        return $this->user->getRemarks();
    }

    public function accept(CantineSeatListReporter $cantineListReporter)
    {
        $cantineListReporter->visitRecord($this);
    }
}

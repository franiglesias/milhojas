<?php

namespace Milhojas\Domain\Cantine\CantineList;

use Milhojas\Library\Sortable\Sortable;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\Turn;

/**
 * A Data Transport Object to hold the representation of a Cantine User in a CantineList.
 */
class CantineListUserRecord implements Sortable
{
    private $date;
    private $turn;
    private $userListName;
    private $classGroupName;
    private $stageName;
    private $remarks;

    /**
     * @param mixed $date
     * @param mixed $turn
     * @param mixed $userListName
     * @param mixed $classGroupName
     * @param mixed $stageName
     * @param mixed $remarks
     */
    public function __construct(
        $date,
        $turn,
        $userListName,
        $classGroupName,
        $stageName,
        $remarks
    ) {
        $this->date = $date;
        $this->turn = $turn;
        $this->userListName = $userListName;
        $this->classGroupName = $classGroupName;
        $this->stageName = $stageName;
        $this->remarks = $remarks;
    }

    /**
     * @param CantineUser        $user
     * @param Turn               $turn
     * @param \DateTimeInterface $date
     */
    public static function createFromUserTurnAndDate(CantineUser $user, Turn $turn, \DateTimeInterface $date)
    {
        $cantineListUserRecord = new self($date, $turn, $user->getListName(), $user->getClassGroupName(), $user->getStageName(), $user->getRemarks());

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

        $result = strcasecmp($this->userListName, $object->getUserListName());

        return $result != 0 ? $result / abs($result) : 0;
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
        return $this->userListName;
    }

    public function getClassGroupName()
    {
        return $this->classGroupName;
    }

    public function getStageName()
    {
        return $this->stageName;
    }

    public function getRemarks()
    {
        return $this->remarks;
    }

    public function accept(CantineListReporter $cantineListReporter)
    {
        $cantineListReporter->visitRecord($this);
    }
}

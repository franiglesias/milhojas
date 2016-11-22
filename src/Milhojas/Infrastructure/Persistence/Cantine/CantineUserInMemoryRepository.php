<?php

namespace Milhojas\Infrastructure\Persistence\Cantine;

use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\CantineUserRepository;

class CantineUserInMemoryRepository implements CantineUserRepository
{
    private $users;
    /**
     * {@inheritdoc}
     */
    public function store(CantineUser $user)
    {
        $id = $user->getStudentId()->getId();
        $this->users[$id] = $user;
    }

    /**
     * {@inheritdoc}
     */
    public function retrieve($id)
    {
        $id = $id->getId();
        if (!isset($this->users[$id])) {
            return null;
        }

        return $this->users[$id];
    }

    public function getUsersForDate(\DateTime $date)
    {
        $response = array();
        foreach ($this->users as $User) {
            if ($User->isEatingOnDate($date)) {
                $response[] = $User;
            }
        }

        return $response;
    }
}

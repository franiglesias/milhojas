<?php

namespace Milhojas\Infrastructure\Persistence\Cantine;

use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\CantineUserRepository;
use Milhojas\Domain\Cantine\Exception\CantineUserNotFound;
use Milhojas\Domain\Cantine\Specification\CantineUserSpecification;

class CantineUserInMemoryRepository implements CantineUserRepository
{
    private $users = [];
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

    /**
     * {@inheritdoc}
     */
    public function get(CantineUserSpecification $cantineUserSpecification)
    {
        foreach ($this->users as $id => $user) {
            if ($cantineUserSpecification->isSatisfiedBy($user)) {
                return $user;
            }
        }
        throw new CantineUserNotFound('Student is not registered as Cantine User');
    }

    /**
     * {@inheritdoc}
     */
    public function find(CantineUserSpecification $cantineUserSpecification)
    {
        $list = [];
        foreach ($this->users as $id => $user) {
            if ($cantineUserSpecification->isSatisfiedBy($user)) {
                $list[] = $user;
            }
        }

        return $list;
    }
}

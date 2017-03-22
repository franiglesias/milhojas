<?php

namespace Milhojas\Infrastructure\Persistence\Cantine;

use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\CantineUserRepository;
use Milhojas\Domain\Cantine\Exception\CantineUserNotFound;
use Milhojas\Domain\Cantine\Specification\CantineUserSpecification;

class CantineUserInMemoryRepository implements CantineUserRepository
{
    private $users = [];

    public function __construct()
    {
        $this->users = new \SplObjectStorage();
    }
    /**
     * {@inheritdoc}
     */
    public function store(CantineUser $user)
    {
        $this->users->attach($user);
    }

    /**
     * {@inheritdoc}
     */
    public function retrieve($id)
    {
        foreach ($this->users as $user) {
            if ($user->getStudentId() == $id) {
                return $user;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function get(CantineUserSpecification $cantineUserSpecification)
    {
        foreach ($this->users as $user) {
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

<?php

namespace Milhojas\Domain\Cantine;

class Assigner
{
    private $rules;

    public function __construct(Rules $rules)
    {
        $this->rules = $rules;
    }

    public function assignUsersForDate($users, \DateTime $date)
    {
        $rules = $this->rules->getAll();
        foreach ($users as $user) {
            $rules->assignsUserToTurn($user, $date);
        }
    }
}

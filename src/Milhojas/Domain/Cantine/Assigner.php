<?php

namespace Milhojas\Domain\Cantine;

class Assigner
{
    private $rules;

    public function __construct(Rule $rules)
    {
        $this->rules = $rules;
    }

    public function assignUsersForDate($users, \DateTime $date)
    {
        foreach ($users as $user) {
            $this->rules->assignsUserToTurn($user, $date);
        }
    }
}

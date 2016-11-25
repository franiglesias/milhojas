<?php

namespace Milhojas\Domain\Cantine;

class Assigner
{
    private $rules;

    /**
     * Adds a rule.
     *
     * @param TurnRule $turnRule
     */
    public function addRule(TurnRule $turnRule)
    {
        if (!$this->rules) {
            $this->rules = $turnRule;

            return;
        }
        $this->rules->chain($turnRule);
    }

    /**
     * Run the assignment process.
     *
     * @param \DateTime $date
     * @param mixed     $users
     */
    public function generateListFor(\DateTime $date, $users)
    {
        $result = [];
        foreach ($users as $User) {
            $turn = $this->rules->getAssignedTurn($User, $date);
            if ($turn) {
                $result[$turn][] = $User;
            }
        }

        return $result;
    }
}

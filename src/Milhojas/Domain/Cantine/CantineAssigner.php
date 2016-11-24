<?php

namespace Milhojas\Domain\Cantine;

class CantineAssigner
{
    private $rules;

    /**
     * Adds a rule.
     *
     * @param TurnRule $turnRule
     */
    public function addRule(TurnRule $turnRule)
    {
        $this->rules[] = $turnRule;
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
            foreach ($this->rules as $rule) {
                $turn = $rule->getAssignedTurn($User, $date);
                if ($turn) {
                    $result[$turn][] = $User;
                    continue;
                }
            }
        }

        return $result;
    }

    public function countRules()
    {
        return count($this->rules);
    }
}

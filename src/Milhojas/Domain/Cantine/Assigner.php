<?php

namespace Milhojas\Domain\Cantine;

use Symfony\Component\Yaml\Yaml;
use Milhojas\Domain\Utils\Schedule\WeeklySchedule;

class Assigner
{
    private $rules;
    private $turns;

    public function __construct($cantine_configuration_file)
    {
        $config = Yaml::parse(file_get_contents($cantine_configuration_file));
        $this->loadTurns($config);
        $this->loadRules($config);
    }

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

    public function getTurns()
    {
        return $this->turns;
    }

    /**
     * Load the turns in the order they are found in the cantine.yml file under key turns.
     *
     * @param mixed $config Date read from config file
     */
    private function loadTurns($config)
    {
        $turnsOrder = 0;
        foreach ($config['turns'] as $turnName) {
            $this->turns[$turnsOrder] = new Turn($turnName, $turnsOrder);
            ++$turnsOrder;
        }
    }

    private function loadRules($config)
    {
        foreach ($config['rules'] as $key => $rule) {
            $this->addRule(
                new TurnRule(
                    $this->getTurnByName($rule['turn']),
                    new WeeklySchedule(explode(', ', $rule['schedule'])),
                    new CantineGroup($rule['group']),
                    [],
                    []
                    )

                );
        }
    }

    private function getTurnByName($name)
    {
        foreach ($this->turns as $turn) {
            if ($turn->getName() == $name) {
                return $turn;
            }
        }
    }
}

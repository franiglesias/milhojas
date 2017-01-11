<?php

namespace Milhojas\Domain\Cantine\Factories;

use Milhojas\Domain\Cantine\Rule;
use Milhojas\Domain\Utils\Schedule\WeeklySchedule;

class RuleFactory
{
    private $turns;
    private $rules;
    private $groups;

    public function __construct($config, TurnsFactory $turns, GroupsFactory $groups)
    {
        $this->rules = null;
        $this->configure($config, $turns, $groups);
    }

    private function configure($config, $turns, $groups)
    {
        foreach ($config as $name => $rule) {
            $turn = $turns->getTurn($rule['turn']);
            $group = $groups->getGroup($rule['group']);
            $schedule = new WeeklySchedule($rule['schedule']);
            $this->addRule(new Rule($turn, $schedule, $group, [], []));
        }
    }

    public function getAll()
    {
        return $this->rules;
    }

    private function addRule(Rule $rule)
    {
        if (!$this->rules) {
            $this->rules = $rule;

            return;
        }
        $this->rules->chain($rule);
    }
}

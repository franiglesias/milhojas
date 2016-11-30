<?php

namespace Milhojas\Domain\Cantine\Factories;

use Milhojas\Domain\Cantine\Turns;
use Milhojas\Domain\Cantine\Groups;
use Milhojas\Domain\Cantine\Rule;
use Milhojas\Domain\Utils\Schedule\WeeklySchedule;

class RuleFactory
{
    private $turns;
    private $rules;
    private $groups;

    public function __construct()
    {
        $this->rules = null;
    }

    public function configure($config, TurnsFactory $turns, GroupsFactory $groups)
    {
        $this->turns = $turns;
        $this->groups = $groups;
        foreach ($config as $name => $rule) {
            $turn = $this->turns->getTurn($rule['turn']);
            $group = $this->groups->getGroup($rule['group']);
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

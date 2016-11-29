<?php

namespace Milhojas\Infrastructure\Persistence\Cantine;

use Milhojas\Domain\Cantine\Turns;
use Milhojas\Domain\Cantine\Rules;
use Milhojas\Domain\Cantine\Groups;
use Milhojas\Domain\Cantine\Rule;
use Milhojas\Domain\Utils\Schedule\WeeklySchedule;
use Symfony\Component\Yaml\Yaml;

class RuleRepository implements Rules
{
    private $turns;
    private $rules;
    private $groups;

    public function __construct(Turns $turns, Groups $groups)
    {
        $this->turns = $turns;
        $this->groups = $groups;
        $this->rules = null;
    }

    public function addRule(Rule $rule)
    {
        if (!$this->rules) {
            $this->rules = $rule;

            return;
        }
        $this->rules->chain($rule);
    }

    public function getAll()
    {
        return $this->rules;
    }

    public function load($pathToFile)
    {
        $config = Yaml::parse(file_get_contents($pathToFile));
        foreach ($config['rules'] as $name => $rule) {
            $turn = $this->turns->getByName($rule['turn']);
            $group = $this->groups->getByName($rule['group']);
            $schedule = new WeeklySchedule($rule['schedule']);
            $this->addRule(new Rule($turn, $schedule, $group, [], []));
        }
    }
}

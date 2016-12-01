<?php

namespace Milhojas\Domain\Cantine\Factories;

use Symfony\Component\Yaml\Yaml;

class CantineManager
{
    private $allergens;
    private $turns;
    private $groups;
    private $rules;

    public function __construct($file, AllergensFactory $allergens, TurnsFactory $turns, GroupsFactory $groups, RuleFactory $rules)
    {
        $this->allergens = $allergens;
        $this->turns = $turns;
        $this->groups = $groups;
        $this->rules = $rules;
        $this->configure($file);
    }

    public function getBlankAllergensSheet()
    {
        return $this->allergens->getBlankAllergensSheet();
    }

    public function getTurn($turnName)
    {
        return $this->turns->getTurn($turnName);
    }

    public function getTurns()
    {
        return $this->turns->getTurns();
    }
    public function getGroup($name)
    {
        return $this->groups->getGroup($name);
    }

    public function getRules()
    {
        return $this->rules->getAll();
    }

    /**
     * Configure factories.
     *
     * @param [type] $file [Description]
     */
    private function configure($file)
    {
        if (!file_exists($file)) {
            throw new \InvalidArgumentException(sprintf('%s is not a valid cantine configuration file', $file));
        }
        $config = Yaml::parse(file_get_contents($file));
        $this->allergens->configure($config['allergens']);
        $this->turns->configure($config['turns']);
        $this->groups->configure($config['groups']);
        $this->rules->configure($config['rules'], $this->turns, $this->groups);
    }

}

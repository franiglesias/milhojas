<?php

namespace Milhojas\Domain\Cantine\Factories;

use Milhojas\Domain\Cantine\Turn;
use Symfony\Component\Yaml\Yaml;

/**
 * A class to hold all configuration aspects for Cantine Service/Context.
 */
class CantineManager
{
    private $allergens;
    private $turns;
    private $groups;
    private $rules;
    private $file;

    public function __construct($file)
    {
        if (!file_exists($file)) {
            throw new \InvalidArgumentException(sprintf('%s is not a valid cantine configuration file', $file));
        }
        $this->file = $file;
        $config = Yaml::parse(file_get_contents($file));

        $this->turns = new TurnsFactory($config['turns']);
        $this->groups = new GroupsFactory($config['groups']);
        $this->allergens = new AllergensFactory($config['allergens']);
        $this->rules = new RuleFactory($config['rules'], $this->turns, $this->groups);
    }

    /**
     * Provides a BlankAllergensSheets for CantineUsers.
     */
    public function getBlankAllergensSheet()
    {
        return $this->allergens->getBlankAllergensSheet();
    }

    /**
     * Get a Turn Object.
     *
     * @param Turn $turnName
     */
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
}

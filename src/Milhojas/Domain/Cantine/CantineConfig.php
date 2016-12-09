<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\Factories\RuleFactory;
use Milhojas\Domain\Cantine\Factories\TurnsFactory;
use Milhojas\Domain\Cantine\Factories\GroupsFactory;
use Symfony\Component\Yaml\Yaml;

class CantineConfig
{
    private $turnFactory;
    private $groupFactory;
    private $ruleFactory;

    /**
     * @param mixed $turnFactory
     * @param mixed $groupFactory
     * @param mixed $ruleFactory
     */
    public function __construct(TurnsFactory $turnFactory, GroupsFactory $groupFactory, RuleFactory $ruleFactory)
    {
        $this->turnFactory = $turnFactory;
        $this->groupFactory = $groupFactory;
        $this->ruleFactory = $ruleFactory;
    }
    public function getTurn($turn)
    {
        return $this->turnFactory->getTurn($turn);
    }

    public function getTurns()
    {
        return $this->turnFactory->getTurns();
    }

    public function getGroup($name)
    {
        return $this->groupFactory->getGroup($name);
    }

    public function getRules()
    {
        return $this->ruleFactory->getAll();
    }

    public function load($file)
    {
        if (!file_exists($file)) {
            throw new \InvalidArgumentException(sprintf('%s is not a valid cantine configuration file', $file));
        }
        $config = Yaml::parse(file_get_contents($file));
        $this->turnFactory->configure($config['turns']);
        $this->groupFactory->configure($config['groups']);
        $this->ruleFactory->configure($config['rules'], $this->turnFactory, $this->groupFactory);
    }
}

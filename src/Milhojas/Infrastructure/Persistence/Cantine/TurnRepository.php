<?php

namespace Milhojas\Infrastructure\Persistence\Cantine;

use Milhojas\Domain\Cantine\Turn;
use Milhojas\Domain\Cantine\Turns;
use Symfony\Component\Yaml\Yaml;

class TurnRepository implements Turns
{
    private $turns;
    private $indexByName;
    /**
     * {@inheritdoc}
     */
    public function getByName($name)
    {
        return $this->indexByName[$name];
    }

    public function addTurn(Turn $turn)
    {
        $this->turns[] = $turn;
        $this->indexByName[$turn->getName()] = $turn;
    }

    public function load($configurationFile)
    {
        $config = Yaml::parse(file_get_contents($configurationFile));
        $order = 0;
        foreach ($config['turns'] as $turn) {
            $this->addTurn(new Turn($turn, $order));
            ++$order;
        }
    }
}

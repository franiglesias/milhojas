<?php

namespace Milhojas\Domain\Cantine\Factories;

use Milhojas\Domain\Cantine\Turn;

class TurnsFactory
{
    private $turns;
    private $indexByName;

    public function configure(array $turns)
    {
        foreach ($turns as $name) {
            $turn = new Turn($name, count($this->turns));
            $this->turns[] = $turn;
            $this->indexByName[$name] = $turn;
        }
    }

    public function getTurn($name)
    {
        return $this->indexByName[$name];
    }

    public function getTurns()
    {
        return $this->turns;
    }
}

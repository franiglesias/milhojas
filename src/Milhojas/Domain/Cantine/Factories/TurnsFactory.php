<?php

namespace Milhojas\Domain\Cantine\Factories;

use Milhojas\Domain\Cantine\Turn;

class TurnsFactory
{
    private $turns;

    public function __construct(array $turns)
    {
        foreach ($turns as $name) {
            $turn = new Turn($name, count($this->turns));
            $this->turns[$this->sanitize($name)] = $turn;
        }
    }

    public function getTurn($name)
    {
        return $this->turns[$this->sanitize($name)];
    }

    public function getTurns()
    {
        return $this->turns;
    }

    private function sanitize($name)
    {
        return strtolower(trim($name));
    }
}

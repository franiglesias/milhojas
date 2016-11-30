<?php

namespace Milhojas\Domain\Cantine\Factories;

use Milhojas\Domain\Cantine\CantineGroup;

class GroupsFactory
{
    private $groups;
    private $indexByName;

    public function __construct()
    {
    }

    public function getGroup($name)
    {
        return $this->indexByName[$name];
    }

    private function addGroup(CantineGroup $group)
    {
        $this->groups[] = $group;
        $this->indexByName[$group->getName()] = $group;
    }

    public function configure($config)
    {
        foreach ($config as $name) {
            $this->addGroup(new CantineGroup($name));
        }
    }
}

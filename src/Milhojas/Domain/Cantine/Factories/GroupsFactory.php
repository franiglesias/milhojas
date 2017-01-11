<?php

namespace Milhojas\Domain\Cantine\Factories;

use Milhojas\Domain\Cantine\CantineGroup;

/**
 * Holds the collections of groups.
 */
class GroupsFactory
{
    private $groups;

    public function __construct(array $groups)
    {
        $this->configure($groups);
    }

    public function getGroup($name)
    {
        return $this->groups[$this->sanitize($name)];
    }

    private function addGroup(CantineGroup $group)
    {
        $this->groups[$this->sanitize($group->getName())] = $group;
    }

    private function configure($config)
    {
        foreach ($config as $name) {
            $this->addGroup(new CantineGroup($name));
        }
    }

    private function sanitize($name)
    {
        return strtolower(trim($name));
    }
}

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
        foreach ($groups as $name) {
            $group = new CantineGroup($name);
            $this->groups[$this->sanitize($name)] = $group;
        }
    }

    public function getGroup($name)
    {
        return $this->groups[$this->sanitize($name)];
    }

    public function getGroups()
    {
        return $this->groups;
    }

    private function sanitize($name)
    {
        return strtolower(trim($name));
    }
}

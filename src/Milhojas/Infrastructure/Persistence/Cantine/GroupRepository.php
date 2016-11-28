<?php

namespace Milhojas\Infrastructure\Persistence\Cantine;

use Milhojas\Domain\Cantine\Groups;
use Milhojas\Domain\Cantine\CantineGroup;
use Symfony\Component\Yaml\Yaml;

class GroupRepository implements Groups
{
    private $groups;
    private $indexByName;
    /**
     * {@inheritdoc}
     */
    public function getByName($name)
    {
        return $this->indexByName[$name];
    }

    public function addGroup(CantineGroup $group)
    {
        $this->groups[] = $group;
        $this->indexByName[$group->getName()] = $group;
    }

    public function load($configurationFile)
    {
        $config = Yaml::parse(file_get_contents($configurationFile));
        foreach ($config['groups'] as $name) {
            $this->addGroup(new CantineGroup($name));
        }
    }
}

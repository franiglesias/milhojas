<?php

namespace spec\Milhojas\Domain\Cantine\Factories;

use Milhojas\Domain\Cantine\CantineGroup;
use Milhojas\Domain\Cantine\Factories\GroupsFactory;
use PhpSpec\ObjectBehavior;

class GroupsFactorySpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(['Grupo 1', 'Grupo 2', 'Grupo 3', 'Grupo 4']);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(GroupsFactory::class);
    }

    public function it_creates_the_groups_configured()
    {
        $this->getGroup('Grupo 1')->shouldHaveType(CantineGroup::class);
        $this->getGroup('Grupo 2')->shouldHaveType(CantineGroup::class);
        $this->getGroup('Grupo 3')->shouldHaveType(CantineGroup::class);
        $this->getGroup('Grupo 4')->shouldHaveType(CantineGroup::class);
    }
}

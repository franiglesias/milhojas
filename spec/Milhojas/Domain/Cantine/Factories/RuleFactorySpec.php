<?php

namespace spec\Milhojas\Domain\Cantine\Factories;

use Milhojas\Domain\Cantine\Factories\RuleFactory;
use Milhojas\Domain\Cantine\Factories\GroupsFactory;
use Milhojas\Domain\Cantine\Factories\TurnsFactory;
use Milhojas\Domain\Cantine\CantineGroup;
use Milhojas\Domain\Cantine\Turn;
use Milhojas\Domain\Cantine\Rule;
use PhpSpec\ObjectBehavior;

class RuleFactorySpec extends ObjectBehavior
{
    public function let(TurnsFactory $turns, GroupsFactory $groups, Turn $turn, CantineGroup $group)
    {
        $rules = [
            'rule 1' => [
                'turn' => 'Turno 1',
                'schedule' => ['monday', 'wednesday', 'friday'],
                'group' => 'Group 1',
            ],
            'rule 2' => [
                'turn' => 'Turno 2',
                'schedule' => ['tuesday', 'thursday'],
                'group' => 'Group 1',
            ],

        ];
        $turns->getTurn('Turno 1')->willReturn($turn);
        $turns->getTurn('Turno 2')->willReturn($turn);
        $groups->getGroup('Group 1')->willReturn($group);
        $this->beConstructedWith();
        $this->configure($rules, $turns, $groups);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(RuleFactory::class);
    }

    public function it_can_return_the_chain_of_rules()
    {
        $this->getAll()->shouldHaveType(Rule::class);
    }
}

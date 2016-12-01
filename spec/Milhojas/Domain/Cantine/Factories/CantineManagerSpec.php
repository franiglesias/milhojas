<?php

namespace spec\Milhojas\Domain\Cantine\Factories;

use Milhojas\Domain\Cantine\Allergens;
use Milhojas\Domain\Cantine\Factories\CantineManager;
use Milhojas\Domain\Cantine\Factories\RuleFactory;
use Milhojas\Domain\Cantine\Factories\TurnsFactory;
use Milhojas\Domain\Cantine\Factories\GroupsFactory;
use Milhojas\Domain\Cantine\Factories\AllergensFactory;
use PhpSpec\ObjectBehavior;
use org\bovigo\vfs\vfsStream;
use Symfony\Component\Yaml\Yaml;
use Prophecy\Argument;

class CantineManagerSpec extends ObjectBehavior
{
    public function let(AllergensFactory $allergens, TurnsFactory $turns, GroupsFactory $groups, RuleFactory $rules)
    {
        $this->beConstructedWith($this->getConfigFile(), $allergens, $turns, $groups, $rules);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CantineManager::class);
    }

    public function it_needs_a_file_in_order_to_configurate($allergens, $turns, $groups, $rules)
    {
        $this->beConstructedWith('false.yml', $allergens, $turns, $groups, $rules);
        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();
    }

    public function it_creates_blank_allergens_checklists($allergens)
    {
        $allergens->configure(Argument::any())->shouldBeCalled();
        $allergens->getBlankAllergensSheet()->shouldBeCalled();
        $this->getBlankAllergensSheet();
    }

    public function it_creates_turns($turns)
    {
        $turns->configure(Argument::any())->shouldBeCalled();
        $turns->getTurn('Turno 1')->shouldBeCalled()->willReturn('something');
        $this->getTurn('Turno 1')->shouldReturn('something');
    }

    public function it_can_give_the_list_of_turns($turns)
    {
        $turns->configure(Argument::any())->shouldBeCalled();
        $turns->getTurns()->shouldBeCalled()->willReturn('something');
        $this->getTurns()->shouldReturn('something');
    }

    public function it_can_give_cantine_groups_by_name($groups)
    {
        $groups->configure(Argument::any())->shouldBeCalled();
        $groups->getGroup('Group 1')->shouldBeCalled()->willReturn('something');
        $this->getGroup('Group 1')->shouldReturn('something');
    }

    public function it_can_give_the_rules($rules, $turns, $groups)
    {
        $rules->configure(Argument::any(), $turns, $groups)->shouldBeCalled();
        $rules->getAll()->shouldBeCalled()->willReturn('something');
        $this->getRules()->shouldReturn('something');
    }

    private function getConfigFile()
    {
        $config = [
            'allergens' => ['almonds', 'gluten', 'fish', 'eggs', 'seafood'],
            'turns' => ['Turno 1', 'Turno 2', 'Turno 3', 'Turno 4'],
            'groups' => ['Grupo 1', 'Grupo 2'],
            'rules' => [
                'rule 1' => [
                    'turn' => 'Turno 1',
                    'schedule' => ['monday', 'wednesday', 'friday'],
                    'group' => 'Grupo 1',
                ],
                'rule 2' => [
                    'turn' => 'Turno 2',
                    'schedule' => ['tuesday', 'thursday'],
                    'group' => 'Grupo 1',
                ],
            ],
        ];
        $fileSystem = vfsStream::setUp('root', 0, []);
        $file = vfsStream::newFile('cantine.yml')
            ->withContent(Yaml::dump($config))
            ->at($fileSystem);

        return $file->url();
    }
}

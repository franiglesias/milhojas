<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\CantineConfig;
use Milhojas\Domain\Cantine\Factories\RuleFactory;
use Milhojas\Domain\Cantine\Factories\TurnsFactory;
use Milhojas\Domain\Cantine\Factories\GroupsFactory;
use org\bovigo\vfs\vfsStream;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Yaml\Yaml;

class CantineConfigSpec extends ObjectBehavior
{
    public function let(TurnsFactory $turns, GroupsFactory $groups, RuleFactory $rules)
    {
        $this->beConstructedWith($turns, $groups, $rules);
        $this->load($this->getConfigFile());
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CantineConfig::class);
    }

    public function it_needs_a_file_in_order_to_configurate()
    {
        $this->shouldThrow(\InvalidArgumentException::class)->during('load', ['false.yml']);
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

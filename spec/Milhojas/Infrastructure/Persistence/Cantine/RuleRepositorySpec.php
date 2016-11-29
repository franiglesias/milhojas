<?php

namespace spec\Milhojas\Infrastructure\Persistence\Cantine;

use Milhojas\Domain\Cantine\Turns;
use Milhojas\Domain\Cantine\Rules;
use Milhojas\Domain\Cantine\Turn;
use Milhojas\Domain\Cantine\Groups;
use Milhojas\Domain\Cantine\TurnRule;
use Milhojas\Domain\Cantine\CantineGroup;
use Milhojas\Infrastructure\Persistence\Cantine\RuleRepository;
use PhpSpec\ObjectBehavior;
use org\bovigo\vfs\vfsStream;
use Symfony\Component\Yaml\Yaml;

class RuleRepositorySpec extends ObjectBehavior
{
    public function let(Turns $turns, Groups $groups)
    {
        $this->beConstructedWith($turns, $groups);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(RuleRepository::class);
        $this->shouldImplement(Rules::class);
    }

    public function it_can_add_rules(TurnRule $rule, TurnRule $rule2)
    {
        $rule->chain()->shouldNotBeCalled();
        $rule->chain($rule2)->shouldBeCalled();
        $this->addRule($rule);
        $this->addRule($rule2);
    }

    public function it_can_return_the_chain_of_rules(TurnRule $rule, TurnRule $rule2)
    {
        $rule->chain()->shouldNotBeCalled();
        $this->addRule($rule);
        $rule->chain($rule2)->shouldBeCalled();
        $this->addRule($rule2);
        $this->getAll()->shouldBe($rule);
    }

    public function it_loads_rules_from_configuration_file($turns, $groups, Turn $turn0, Turn $turn1, CantineGroup $group1)
    {
        $turns->getByName('Turno 0')->willReturn($turn0);
        $turns->getByName('Turno 1')->willReturn($turn1);
        $groups->getByName('Group 1')->willReturn($group1);
        $this->load($this->getMockedConfigurationFile());
        $this->getAll()->shouldHaveType(TurnRule::class);
    }

    private function getMockedConfigurationFile()
    {
        $fileSystem = vfsStream::setUp('root', 0, []);
        $map = array(
            'turns' => array(
                'Turno 0',
                'Turno 1',
                'Turno 2',
            ),
            'rules' => array(
                'rule 1' => array(
                    'turn' => 'Turno 0',
                    'schedule' => ['monday', 'wednesday', 'friday'],
                    'group' => 'Group 1',
                ),
                'rule 2' => array(
                    'turn' => 'Turno 1',
                    'schedule' => ['tuesday', 'thursday'],
                    'group' => 'Group 1',
                ),
            ),
        );
        $file = vfsStream::newFile('cantine.yml')
            ->withContent(Yaml::dump($map))
            ->at($fileSystem);

        return $file->url();
    }
}

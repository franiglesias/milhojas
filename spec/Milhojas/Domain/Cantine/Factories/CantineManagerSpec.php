<?php

namespace spec\Milhojas\Domain\Cantine\Factories;

use Milhojas\Domain\Cantine\Rule;
use Milhojas\Domain\Cantine\Turn;
use Milhojas\Domain\Cantine\Allergens;
use Milhojas\Domain\Cantine\CantineGroup;
use Milhojas\Domain\Cantine\Factories\CantineManager;
use Milhojas\Library\Collections\Checklist;
use PhpSpec\ObjectBehavior;
use org\bovigo\vfs\vfsStream;
use Symfony\Component\Yaml\Yaml;

class CantineManagerSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith($this->getConfigFile());
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CantineManager::class);
    }

    public function it_needs_a_file_in_order_to_configurate()
    {
        $this->beConstructedWith('false.yml');
        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();
    }

    public function it_creates_blank_allergens_checklists()
    {
        $expected = new Allergens(new Checklist(['almonds', 'gluten', 'fish', 'eggs', 'seafood']));
        $this->getBlankAllergensSheet()->shouldHaveType(Allergens::class);
        $this->getBlankAllergensSheet()->shouldBeLike($expected);
    }

    public function it_creates_turns()
    {
        $this->getTurn('Turno 1')->shouldHaveType(Turn::class);
        $this->getTurn('Turno 1')->shouldBeLike(new Turn('Turno 1', 0));
    }

    public function it_can_give_the_list_of_turns()
    {
        $this->getTurns()->shouldBeArray();
    }

    public function it_can_give_cantine_groups_by_name()
    {
        $this->getGroup('Grupo 1')->shouldHaveType(CantineGroup::class);
    }

    public function it_can_give_the_rules()
    {
        $this->getRules()->shouldHaveType(Rule::class);
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

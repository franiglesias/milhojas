<?php

namespace spec\Milhojas\Infrastructure\Persistence\Cantine;

use Milhojas\Infrastructure\Persistence\Cantine\GroupRepository;
use Milhojas\Domain\Cantine\Groups;
use Milhojas\Domain\Cantine\CantineGroup;
use org\bovigo\vfs\vfsStream;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Yaml\Yaml;

class GroupRepositorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(GroupRepository::class);
        $this->shouldImplement(Groups::class);
    }

    public function it_can_load_from_configuration_file()
    {
        $this->load($this->getMockedConfigurationFile());
        $this->getByName('Grupo 1')->shouldHaveType(CantineGroup::class);
        $this->getByName('Grupo 2')->shouldHaveType(CantineGroup::class);
        $this->getByName('Grupo 3')->shouldHaveType(CantineGroup::class);
        $this->getByName('Grupo 4')->shouldHaveType(CantineGroup::class);
    }

    private function getMockedConfigurationFile()
    {
        $fileSystem = vfsStream::setUp('root', 0, []);
        $map = array(
            'groups' => array(
                'Grupo 1',
                'Grupo 2',
                'Grupo 3',
                'Grupo 4',
            ),
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

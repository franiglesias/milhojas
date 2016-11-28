<?php

namespace spec\Milhojas\Infrastructure\Persistence\Cantine;

use Milhojas\Infrastructure\Persistence\Cantine\TurnRepository;
use Milhojas\Domain\Cantine\Turn;
use Milhojas\Domain\Cantine\Turns;
use org\bovigo\vfs\vfsStream;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Yaml\Yaml;

class TurnRepositorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(TurnRepository::class);
        $this->shouldImplement(Turns::class);
    }

    public function it_can_add_turn(Turn $turn)
    {
        $turn->getName()->willReturn('Turn');
        $this->addTurn($turn);
        $this->getByName('Turn')->shouldBe($turn);
    }

    public function it_can_load_turns_from_configuration_file()
    {
        $this->load($this->getMockedConfigurationFile());
        $this->getByName('Turno 0')->shouldHaveType(Turn::class);
        $this->getByName('Turno 1')->shouldHaveType(Turn::class);
        $this->getByName('Turno 2')->shouldHaveType(Turn::class);
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

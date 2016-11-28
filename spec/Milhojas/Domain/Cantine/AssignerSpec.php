<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\TurnRule;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\Assigner;
use PhpSpec\ObjectBehavior;
use org\bovigo\vfs\vfsStream;
use Symfony\Component\Yaml\Yaml;

class AssignerSpec extends ObjectBehavior
{
    private $fileSystem;

    public function let()
    {
        $this->beConstructedWith($this->getMockedConfigurationFile());
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Assigner::class);
    }

    public function it_loads_turns_on_creation()
    {
        $this->getTurns()->shouldBeArray();
    }

    public function it_can_generate_a_list_for_a_date(TurnRule $rule1, CantineUser $User1, TurnRule $rule2, CantineUser $User2, TurnRule $rule3,  \DateTime $date)
    {
        $rule1->getAssignedTurn($User1, $date)->willReturn(1);
        $rule1->getAssignedTurn($User2, $date)->willReturn(2);

        $rule1->chain($rule2)->shouldBeCalled();
        $this->addRule($rule1);
        $this->addRule($rule2);

        $list = $this->generateListFor($date, [$User1, $User2]);
        $list->shouldBeArray();
        $list->shouldHaveCount(2);
        $list[1][0]->shouldBe($User1);
        $list[2][0]->shouldBe($User2);
    }

    private function getMockedConfigurationFile()
    {
        $this->fileSystem = vfsStream::setUp('root', 0, []);
        $map = array(
            'turns' => array(
                'Turno 0',
                'Turno 1',
                'Turno 2',
            ),
            'rules' => array(
                'rule 1' => array(
                    'turn' => 'Turno 0',
                    'schedule' => 'monday, wednesday, friday',
                    'group' => 'Group 1',
                ),
                'rule 2' => array(
                    'turn' => 'Turno 1',
                    'schedule' => 'tuesday, thursday',
                    'group' => 'Group 1',
                ),
            ),
        );
        $file = vfsStream::newFile('cantine.yml')
            ->withContent(Yaml::dump($map))
            ->at($this->fileSystem);

        return $file->url();
    }
}

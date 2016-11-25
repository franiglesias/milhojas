<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\CantineGroupMapper;
use Milhojas\Domain\Cantine\CantineGroup;
use Milhojas\Domain\School\Student;
use Milhojas\Domain\School\StudentGroup;
use PhpSpec\ObjectBehavior;
use org\bovigo\vfs\vfsStream;
use Symfony\Component\Yaml\Yaml;

class CantineGroupMapperSpec extends ObjectBehavior
{
    private $fileSystem;

    public function let()
    {
        $this->fileSystem = vfsStream::setup('root', 0, []);
        $map = array(
            'class_cantine_map' => array(
                'New Student' => 'Group 1',
                'Old Student' => 'Group 2',
            ),
        );
        $file = vfsStream::newFile('groups.yml')
                      ->withContent(Yaml::dump($map))
                      ->at($this->fileSystem);

        $this->beConstructedWith($file->url());
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CantineGroupMapper::class);
    }

    public function it_loads_map_from_file()
    {
        $this->getMapFor(new StudentGroup('New Student'))->shouldBeLike(new CantineGroup('Group 1'));
    }

    public function it_tells_the_cantine_group_for_student(Student $student)
    {
        $student->getGroup()->willReturn(new StudentGroup('New Student'));
        $this->getGroupForStudent($student)->shouldBeLike(new CantineGroup('Group 1'));
    }
}
<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\CantineGroupMapper;
use Milhojas\Domain\Cantine\CantineGroup;
use Milhojas\Domain\School\Student;
use PhpSpec\ObjectBehavior;

class CantineGroupMapperSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(CantineGroupMapper::class);
    }

    public function it_loads_map_from_file()
    {
        $file = 'groups.yml';
        $this->beConstructedWith($file);
    }

    public function it_maps_student_to_cantine_group(Student $student)
    {
        $this->getGroup($student)->shouldHaveType(CantineGroup::class);
    }
}

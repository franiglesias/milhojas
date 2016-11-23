<?php

namespace spec\Milhojas\Domain\School;

use Milhojas\Domain\School\StudentGroup;
use Milhojas\Domain\School\NewStudentGroup;
use PhpSpec\ObjectBehavior;

class NewStudentGroupSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(NewStudentGroup::class);
        $this->shouldHaveType(StudentGroup::class);
    }

    public function it_has_a_fixed_name()
    {
        $this->getName()->shouldBe('New Students');
    }
}

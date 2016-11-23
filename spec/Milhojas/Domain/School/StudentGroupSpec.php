<?php

namespace spec\Milhojas\Domain\School;

use Milhojas\Domain\School\StudentGroup;
use PhpSpec\ObjectBehavior;

class StudentGroupSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('New Student');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(StudentGroup::class);
    }

    public function it_can_tell_its_name()
    {
        $this->getName()->shouldBe('New Student');
    }
}

<?php

namespace spec\Milhojas\Domain\Shared;

use Milhojas\Domain\Shared\StudentId;
use PhpSpec\ObjectBehavior;

class StudentIdSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith('identifier');
        $this->shouldHaveType(StudentId::class);
    }

    public function it_can_be_cretaed_with_named_constructor()
    {
        $this->beConstructedThrough('generate', []);
        $this->getId()->shouldBeString();
    }
}

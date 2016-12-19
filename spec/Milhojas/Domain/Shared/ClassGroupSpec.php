<?php

namespace spec\Milhojas\Domain\Shared;

use Milhojas\Domain\Shared\ClassGroup;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ClassGroupSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('3º B Ed. Primaria', 'EP 3 B', 'EP');
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(ClassGroup::class);
    }

    public function it_can_tell_its_name()
    {
        $this->getName()->shouldBe('3º B Ed. Primaria');
    }

    public function it_can_tell_its_short_name()
    {
        $this->getShortName()->shouldBe('EP 3 B');
    }

    public function it_can_tell_its_stage_name()
    {
        $this->getStageName()->shouldBe('EP');
    }
}

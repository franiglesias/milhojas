<?php

namespace spec\Milhojas\Library\ValueObjects\Misc;

use Milhojas\Library\ValueObjects\Misc\Gender;
use PhpSpec\ObjectBehavior;


class GenderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(Gender::MALE);
        $this->shouldHaveType(Gender::class);
    }

    public function it_has_a_constant_defined_for_male()
    {
        $this->beConstructedWith('male');
        $this->getGender()->shouldBe(Gender::MALE);
    }

    public function it_has_a_constant_defined_for_female()
    {
        $this->beConstructedWith('female');
        $this->getGender()->shouldBe(Gender::FEMALE);
    }

    public function it_can_tell_the_gender_is_male()
    {
        $this->beConstructedWith(Gender::MALE);
        $this->getGender()->shouldBe(Gender::MALE);
    }

    public function it_can_tell_the_gender_is_female()
    {
        $this->beConstructedWith(Gender::FEMALE);
        $this->getGender()->shouldBe(Gender::FEMALE);
    }

    public function it_throws_exception_for_invalid_values()
    {
        $this->beConstructedWith('invalid');
        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();
    }

}

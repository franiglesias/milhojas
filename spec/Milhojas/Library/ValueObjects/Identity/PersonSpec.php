<?php

namespace spec\Milhojas\LIbrary\ValueObjects\Identity;

use Milhojas\Library\Sortable\Sortable;
use Milhojas\LIbrary\ValueObjects\Identity\Person;
use Milhojas\Library\ValueObjects\Misc\Gender;
use PhpSpec\ObjectBehavior;


class PersonSpec extends ObjectBehavior
{
    public function let(Gender $gender)
    {
        $this->beConstructedWith('Fran', 'Iglesias', $gender);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(Person::class);
        $this->shouldImplement(Sortable::class);
    }

    public function it_has_name_and_surname()
    {
        $this->getName()->shouldBe('Fran');
        $this->getSurname()->shouldBe('Iglesias');
    }

    public function it_can_build_a_list_name()
    {
        $this->getListName()->shouldBe('Iglesias, Fran');
    }

    public function it_can_build_full_name()
    {
        $this->getFullName()->shouldBe('Fran Iglesias');
    }

    public function it_can_be_compared_with_other()
    {
        $this->compare(new Person('Patricia', 'Iglesias', new Gender(Gender::MALE)))->shouldBe(-1);
    }

    public function it_manages_accented_names()
    {
        $this->compare(new Person('Fernando', 'Álvarez', new Gender(Gender::FEMALE)))->shouldBe(1);
    }

    public function it_throws_exception_for_empty_names()
    {
        $this->beConstructedWith('', '', new Gender(Gender::FEMALE));
        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();
    }
}

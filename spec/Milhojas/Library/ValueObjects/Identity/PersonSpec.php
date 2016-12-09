<?php

namespace spec\Milhojas\LIbrary\ValueObjects\Identity;

use Milhojas\LIbrary\ValueObjects\Identity\Person;
use Milhojas\Library\Sortable\Sortable;
use PhpSpec\ObjectBehavior;

class PersonSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('Fran', 'Iglesias', Person::MALE);
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
        $this->compare(new Person('Patricia', 'Iglesias', Person::FEMALE))->shouldBe(-1);
    }

    public function it_manages_accented_names()
    {
        $this->compare(new Person('Fernando', 'Álvarez', PERSON::MALE))->shouldBe(1);
    }
}

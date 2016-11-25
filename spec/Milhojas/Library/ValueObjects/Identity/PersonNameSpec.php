<?php

namespace spec\Milhojas\Library\ValueObjects\Identity;

use Milhojas\Library\ValueObjects\Identity\PersonName;
use Milhojas\Library\Sortable\Sortable;
use PhpSpec\ObjectBehavior;

class PersonNameSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('Fran', 'Iglesias');
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(PersonName::class);
        $this->shouldImplement(Sortable::class);
    }

    public function it_has_name_and_surname()
    {
        $this->getName()->shouldBe('Fran');
        $this->getSurname()->shouldBe('Iglesias');
    }

    public function it_can_build_a_list_name()
    {
        $this->asListName()->shouldBe('Iglesias, Fran');
    }

    public function it_can_be_compared_with_other()
    {
        $this->compare(new PersonName('Patricia', 'Iglesias'))->shouldBe(-1);
    }

    public function it_manages_accented_names()
    {
        $this->compare(new PersonName('Fernando', 'Álvarez'))->shouldBe(1);
    }
}

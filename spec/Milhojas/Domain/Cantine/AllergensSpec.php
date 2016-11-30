<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\Allergens;
use Milhojas\Library\Collections\Checklist;
use PhpSpec\ObjectBehavior;

class AllergensSpec extends ObjectBehavior
{
    public function let(Checklist $checklist)
    {
        $this->beConstructedWith($checklist);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(Allergens::class);
    }

    public function it_can_register_several_allergens($checklist)
    {
        $sample = ['gluten', 'fish'];
        $checklist->check($sample)->shouldBeCalled();
        $this->check($sample);
    }

    public function it_can_tell_if_has_allergies($checklist)
    {
        $checklist->hasMarks()->willReturn(2);
        $this->shouldBeAllergic();
        $checklist->hasMarks()->willReturn(0);
        $this->shouldNotBeAllergic();
    }

    public function it_can_tell_if_two_allergen_lists_have_coincidences($checklist, Allergens $another, CheckList $anotherList)
    {
        $another->list = $anotherList;
        $checklist->hasCoincidencesWith($anotherList)->shouldBeCalled()->willReturn(true);
        $this->shouldHaveCoincidencesWith($another);
    }
}

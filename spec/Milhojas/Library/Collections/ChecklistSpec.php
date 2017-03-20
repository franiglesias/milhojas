<?php

namespace spec\Milhojas\Library\Collections;

use Milhojas\Library\Collections\Checklist;
use PhpSpec\ObjectBehavior;

class ChecklistSpec extends ObjectBehavior
{
    private $elements = ['apple', 'banana', 'orange', 'pineapple'];

    public function let()
    {
        $this->beConstructedWith($this->elements);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(Checklist::class);
    }

    public function it_gets_all_elements_at_creation_time()
    {
        $this->asArray()->shouldBe($this->elements);
    }

    public function its_elements_are_not_checked_by_default()
    {
        foreach ($this->elements as $element) {
            $this->shouldNotBeChecked($element);
        }
    }

    public function it_can_check_all_items()
    {
        $this->checkAll();
        foreach ($this->elements as $element) {
            $this->shouldBeChecked($element);
        }
    }

    public function it_can_uncheck_all_items()
    {
        $this->check('banana');
        $this->check('apple');

        $this->uncheckAll();
        foreach ($this->elements as $element) {
            $this->shouldNotBeChecked($element);
        }
    }

    public function it_can_return_checked_items()
    {
        $this->check('banana');
        $this->check('apple');
        $this->getChecked()->shouldBeLike(['apple', 'banana']);
    }

    public function it_can_return_string_list_of_checked_items()
    {
        $this->check('banana');
        $this->check('apple');
        $this->getListAsString()->shouldBe('apple, banana');
    }

    public function it_can_check_one_item()
    {
        $this->check('banana');
        $this->shouldBeChecked('banana');
    }

    public function it_can_uncheck_an_item()
    {
        $this->check('apple');
        $this->uncheck('apple');
        $this->shouldNotBeChecked('apple');
    }

    public function it_can_check_several_items()
    {
        $this->check(['banana', 'orange']);
        $this->shouldBeChecked('banana');
        $this->shouldBeChecked('orange');
    }

    public function it_can_unckeck_several_items()
    {
        $this->checkAll();
        $this->uncheck(['banana', 'orange']);
        $this->shouldNotBeChecked('banana');
        $this->shouldNotBeChecked('orange');
    }

    public function it_is_case_insensitive()
    {
        $this->check('APPLE');
        $this->shouldBeChecked('apple');
        $this->shouldBeChecked('AppLE');
        $this->check('BanAnA');
        $this->shouldBeChecked('banana');
    }

    public function it_can_say_that_two_lists_have_checked_items_in_common()
    {
        $list = clone $this;
        $list->check('banana');
        $this->check('banana');
        $this->shouldHaveCoincidencesWith($list);
    }

    public function it_can_get_the_coincidences_between_two_lists()
    {
        $list = new Checklist($this->elements);
        $list->check('banana');
        $list->check('orange');

        $this->check('banana');
        $this->check('orange');
        $this->check('apple');

        $this->getCoincidencesWith($list)->shouldContain('banana');
        $this->getCoincidencesWith($list)->shouldContain('orange');
        $this->getCoincidencesWith($list)->shouldNotContain('apple');
    }

    public function it_can_not_speak_about_or_act_on_an_unsupported_item()
    {
        $this->shouldThrow('\InvalidArgumentException')->duringIsChecked('mango');
        $this->shouldThrow('\InvalidArgumentException')->duringCheck('mango');
        $this->shouldThrow('\InvalidArgumentException')->duringUnCheck('mango');
    }

    public function it_can_tell_that_has_marks()
    {
        $this->check('banana');
        $this->check('apple');
        $this->hasMarks()->shouldBe(2);
    }
}

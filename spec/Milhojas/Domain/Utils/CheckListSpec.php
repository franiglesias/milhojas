<?php

namespace spec\Milhojas\Domain\Utils;

use Milhojas\Domain\Utils\CheckList;
use PhpSpec\ObjectBehavior;

class CheckListSpec extends ObjectBehavior
{
    public function let()
    {
        $data = ['orange', 'apple', 'banana', 'strawberry'];
        $this->beConstructedWith($data);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(CheckList::class);
    }

    public function its_items_are_accesible()
    {
        $this['strawberry']->shouldBe(false);
    }

    public function its_items_are_unchecked_by_default()
    {
        $this->shouldNotBeChecked('strawberry');
        $this->shouldNotBeChecked('orange');
    }

    public function it_can_check_item()
    {
        $this->check('strawberry');
        $this->shouldBeChecked('strawberry');
    }

    public function it_knows_if_several_items_are_checked()
    {
        $this->check(['strawberry', 'apple']);
        $this->shouldBeChecked('strawberry');
        $this->areChecked(['strawberry', 'apple'])->shouldBe(true);
    }

    public function it_can_check_all()
    {
        $this->checkAll();
        $this->shouldBeChecked('orange');
        $this->shouldBeChecked('apple');
    }

    public function it_can_check_several_items_at_once()
    {
        $this->check(['banana', 'apple']);
        $this->shouldBeChecked('banana');
        $this->shouldBeChecked('apple');
    }

    public function it_returns_checked_items_as_checklist()
    {
        $this->check(['banana', 'apple']);
        $this->getChecked()->shouldHaveType(CheckList::class);
        $this->getChecked()->shouldHaveCount(2);
    }

    public function it_is_not_initializable_with_empty_data()
    {
        $this->beConstructedWith();
        $this->shouldThrow('PhpSpec\Exception\Example\ErrorException')->duringInstantiation();
    }

    public function it_is_not_initializable_with_string_as_unique_item()
    {
        $this->beConstructedWith('Item');
        $this->shouldThrow('PhpSpec\Exception\Example\ErrorException')->duringInstantiation();
    }

    public function it_can_intersect_with_another_CheckList_and_return_coincidences()
    {
        $compare = new CheckList(['apple', 'banana', 'pineapple']);
        $this->intersect($compare)->shouldHaveCount(2);
    }
}

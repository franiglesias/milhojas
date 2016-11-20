<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\Allergens;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AllergensSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(['gluten', 'egg', 'fish']);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(Allergens::class);
    }
    public function its_allergens_as_set_to_none_by_default()
    {
        $this->shouldNotBeChecked('gluten');
        $this->shouldNotBeChecked('egg');
        $this->shouldNotBeChecked('fish');
    }
}

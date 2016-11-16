<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\NutritionFacts;
use PhpSpec\ObjectBehavior;

class NutritionFactsSpec extends ObjectBehavior
{
    public function let()
    {
        $proteins = 20;
        $glucides = 10;
        $lipids = 5;
        $calories = 230;

        $this->beConstructedWith(
            $proteins,
            $glucides,
            $lipids,
            $calories
        );
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(NutritionFacts::class);
    }

    public function it_can_tell_calories()
    {
        $this->getCalories()->shouldBe(230);
    }
}

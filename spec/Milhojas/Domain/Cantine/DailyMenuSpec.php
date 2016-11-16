<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\DailyMenu;
use Milhojas\Domain\Cantine\NutritionFacts;
use PhpSpec\ObjectBehavior;

class DailyMenuSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(
            'First\nSecond\nDessert',
            ['gluten', 'fish']
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(DailyMenu::class);
    }

    public function it_can_say_what_allergens_could_contain()
    {
        $this->getAllergens()->shouldReturn(['gluten', 'fish']);
    }

    public function it_can_say_that_it_does_not_contain_allergens()
    {
        $this->beConstructedWith(
            'First\nSecond\nDessert',
            []
        );
        $this->getAllergens()->shouldHaveCount(0);
    }

    public function it_can_say_if_given_allergens_could_be_contained()
    {
        $this->shouldHaveAllergens(['fish']);
        $this->shouldNotHaveAllergens(['almonds']);
    }

    public function it_can_return_dishes_as_array()
    {
        $this->getDishes()->shouldBeArray();
        $this->getDishes()->shouldContain('First');
        $this->getDishes()->shouldContain('Second');
        $this->getDishes()->shouldContain('Dessert');
    }

    public function it_can_be_injected_with_Nutrition_Facts(NutritionFacts $nutritionFacts)
    {
        $this->setNutritionFacts($nutritionFacts);
        $this->getNutritionFacts()->shouldBe($nutritionFacts);
    }
}

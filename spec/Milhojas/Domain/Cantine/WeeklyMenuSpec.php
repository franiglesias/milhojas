<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\DailyMenu;
use Milhojas\Domain\Cantine\WeeklyMenu;
use Milhojas\Domain\Cantine\NutritionFacts;
use PhpSpec\ObjectBehavior;

class WeeklyMenuSpec extends ObjectBehavior
{
    public function let(
        DailyMenu $monday,
        DailyMenu $tuesday,
        DailyMenu $wednesday,
        DailyMenu $thursday,
        DailyMenu $friday,
        NutritionFacts $nutritionFacts
        ) {
        $this->beConstructedWith($monday, $tuesday, $wednesday, $thursday, $friday, $nutritionFacts);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(WeeklyMenu::class);
        $this->shouldHaveCount(5);
    }

    public function it_can_access_any_day_of_week_menu(DailyMenu $monday, DailyMenu $tuesday, DailyMenu $wednesday, DailyMenu $thursday, DailyMenu $friday)
    {
        $this->shouldHaveKeyWithValue('monday', $monday);
        $this->shouldHaveKeyWithValue('tuesday', $tuesday);
        $this->shouldHaveKeyWithValue('wednesday', $wednesday);
        $this->shouldHaveKeyWithValue('thursday', $thursday);
        $this->shouldHaveKeyWithValue('friday', $friday);
    }

    public function it_injects_nutrition_facts_into_daily_menus(DailyMenu $monday, DailyMenu $tuesday, DailyMenu $wednesday, DailyMenu $thursday, DailyMenu $friday, NutritionFacts $nutritionFacts)
    {
        $this['monday']->shouldHaveType('Milhojas\Domain\Cantine\DailyMenu');
        $monday->setNutritionFacts($nutritionFacts)->shouldHaveBeenCalled();
        $tuesday->setNutritionFacts($nutritionFacts)->shouldHaveBeenCalled();
        $wednesday->setNutritionFacts($nutritionFacts)->shouldHaveBeenCalled();
        $thursday->setNutritionFacts($nutritionFacts)->shouldHaveBeenCalled();
        $friday->setNutritionFacts($nutritionFacts)->shouldHaveBeenCalled();
    }
}

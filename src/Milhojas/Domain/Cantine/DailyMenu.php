<?php

namespace Milhojas\Domain\Cantine;

class DailyMenu
{
    private $dishes;
    private $allergens;
    private $nutritionFacts;

    public function __construct($dishes, $allergens)
    {
        $this->dishes = $dishes;
        $this->allergens = $allergens;
    }

    public function getAllergens()
    {
        return $this->allergens;
    }

    public function hasAllergens($list_of_allergens)
    {
        return count(array_intersect($this->allergens, $list_of_allergens)) > 0;
    }

    public function getDishes()
    {
        return explode('\n', $this->dishes);
    }

    public function setNutritionFacts(NutritionFacts $nutritionFacts)
    {
        $this->nutritionFacts = $nutritionFacts;
    }

    public function getNutritionFacts()
    {
        return $this->nutritionFacts;
    }
}

<?php

namespace Milhojas\Domain\Cantine;

class WeeklyMenu implements \ArrayAccess, \Countable
{
    private $days;
    private $facts;

    public function __construct(
        DailyMenu $monday,
        DailyMenu $tuesday,
        DailyMenu $wednesday,
        DailyMenu $thursday,
        DailyMenu $friday,
        NutritionFacts $nutritionFacts)
    {
        $this->facts = $nutritionFacts;
        $this->prepareDailyMenus($monday, $tuesday, $wednesday, $thursday, $friday);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return isset($this->days[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->days[$offset];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->days[$offset] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->days[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->days);
    }

    /**
     * Inject mean Nutrition Facts into Daily Menus and set them as children.
     *
     * @param DailyMenu $monday
     * @param DailyMenu $tuesday
     * @param DailyMenu $wednesday
     * @param DailyMenu $thursday
     * @param DailyMenu $friday
     */
    private function prepareDailyMenus(DailyMenu $monday, DailyMenu $tuesday, DailyMenu $wednesday, DailyMenu $thursday, DailyMenu $friday)
    {
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
        foreach ($days as $day) {
            $$day->setNutritionFacts($this->facts);
            $this[$day] = $$day;
        }
    }
}

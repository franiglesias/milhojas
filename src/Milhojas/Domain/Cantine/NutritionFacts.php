<?php

namespace Milhojas\Domain\Cantine;

class NutritionFacts
{
    private $calories;
    private $glucides;
    private $lipids;
    private $proteins;

    /**
     * @param mixed $proteins
     * @param mixed $glucides
     * @param mixed $lipids
     * @param mixed $calories
     */
    public function __construct($proteins, $glucides, $lipids, $calories)
    {
        $this->proteins = $proteins;
        $this->glucides = $glucides;
        $this->lipids = $lipids;
        $this->calories = $calories;
    }
    /**
     * @return int
     */
    public function getGlucides()
    {
        return $this->glucides;
    }

    /**
     * @return int
     */
    public function getLipids()
    {
        return $this->lipids;
    }

    /**
     * @return int
     */
    public function getProteins()
    {
        return $this->proteins;
    }

    /**
     * @return int
     */
    public function getCalories()
    {
        return $this->calories;
    }
}

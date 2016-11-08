<?php

namespace Milhojas\Domain\School;

use Milhojas\Domain\School\EducationLevel;
use Milhojas\Domain\School\EducationSystem;

/**
 * Describes an Education Stage (primary, secondary, etc...)
 */
class EducationStage
{
    /**
     * Every education stage belongs to an education system
     *
     * @var EducationSystem
     */
    private $system;

    /**
     * the collection of levels in this stage
     *
     * @var array
     */
    private $levels;

    /**
     * The long name for this stage
     *
     * @var string
     */
    private $name;

    /**
     * Short name for this stage
     *
     * @var string
     */
    private $shortname;

    /**
     * Max number of levels in this stage. We need this to allow the building of the level collection
     *
     * @var integer
     */
    private $maxLevels;

    public function __construct(EducationSystem $system, $stage_name, $stage_short_name, $levels_in_stage)
    {
        $this->checkIsValidName($stage_name);
        $this->checkIsValidName($stage_short_name, 2);
        $this->checkIsValidNumberOfLevels($levels_in_stage);

        $this->systen = $system;
        $this->name = $stage_name;
        $this->shortname = $stage_short_name;
        $this->maxLevels = $levels_in_stage;
        for ($i=1; $i <= $this->maxLevels; $i++) {
            $this->addLevel($i);
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function getShortName()
    {
        return $this->shortname;
    }

    public function hasLevels()
    {
        return $this->maxLevels;
    }

    public function getLevels()
    {
        return $this->levels;
    }

    private function addLevel($level)
    {
        $this->levels[] = new EducationLevel($this, $level);
    }

    private function checkIsValidName($name, $min_lenght = 3)
    {
        if (strlen($name) < $min_lenght) {
            throw new \InvalidArgumentException(sprintf('"%s" is not a valid name. It should have at least three characters.', $name));
        }
    }

    private function checkIsValidNumberOfLevels($levels)
    {
        if ($levels == 0) {
            throw new \InvalidArgumentException(sprintf('There must be at leat one level in a stage. You specified %s.', $levels));
        }
    }
}


 ?>

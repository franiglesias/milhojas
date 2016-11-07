<?php

namespace Milhojas\Domain\School;

use Milhojas\Domain\School\EducationLevel;

/**
 * Describes an Education Stage (primary, secondary, etc...)
 */
class EducationStage
{
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

    public function __construct($stage_name, $stage_short_name, $levels_in_stage)
    {
        $this->checkIsValidName($stage_name);
        $this->name = $stage_name;
        $this->checkIsValidName($stage_short_name);
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

    private function checkIsValidName($name)
    {
        if (strlen($name) < 3) {
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

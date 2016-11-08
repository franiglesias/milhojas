<?php

namespace Milhojas\Domain\School;

use Milhojas\Domain\School\EducationLevel;
use Milhojas\Domain\School\EducationSystem;
use Milhojas\Library\ValueObjects\Identity\Name;

/**
 * Describes an Education Stage (primary, secondary, etc...) whitin an Education System
 */
class EducationStage
{
    /**
     * Every education stage belongs to an education system. Provides context.
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

    public function __construct(EducationSystem $system, Name $stage_name, Name $stage_short_name, $levels_in_stage)
    {
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

    public function getSystem()
    {
        return $this->system;

    }

    private function addLevel($level)
    {
        $this->levels[] = new EducationLevel($this, $level);
    }

    private function checkIsValidNumberOfLevels($levels)
    {
        if ($levels == 0) {
            throw new \InvalidArgumentException(sprintf('There must be at leat one level in a stage. You specified %s.', $levels));
        }
    }
}


 ?>
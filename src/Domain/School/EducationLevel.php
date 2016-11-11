<?php

namespace Milhojas\Domain\School;
use Milhojas\Domain\School\EducationStage;
/**
 * Represents an Educational Level whitin a Educational Stage
 *
 */
class EducationLevel
{
    /**
     * The level number
     *
     * @var $level integer
     */
    private $level;

    /**
     * The Stage to which this level belongs
     *
     * @var EducationStage
     */
    private $stage;

    /**
     * Construct an EducationLevel
     *
     * @param EducationStage $stage The stage to which this level belongs
     * @param int $level The number of the level into te limits of the EducationStage
     * @return void
     */
    public function __construct(EducationStage $stage, $level)
    {
        $this->stage = $stage;
        $this->checkIfLevelIsWhitinStageLimits($level);
        $this->level = $level;
    }

    public function getFullName()
    {
        return sprintf('%2$s %1$s', $this->stage->getName(), $this->level);
    }

    public function getShortName()
    {
        return sprintf('%1$s %2$s', $this->stage->getShortName(), $this->level);
    }

    public function getName()
    {
        return $this->level;
    }

    /**
     * Checks if the level is whitin the limits of the stage
     * @param mixed $level
     * @return bool
     */
    private function checkIfLevelIsWhitinStageLimits($level)
    {
        if ($level > $this->stage->getMaxLevels()) {
            throw new \InvalidArgumentException(sprintf('Level %s doesn\'t exist in stage %s', $level, $this->stage->getShortName()));
        }
    }

    /**
     * Casts to String
     */
    public function __toString()
    {
        return $this->getName();
    }
}

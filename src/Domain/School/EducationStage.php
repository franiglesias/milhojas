<?php

namespace Milhojas\Domain\School;

use Milhojas\Library\ValueObjects\Identity\Name;

/**
 * Describes an Education Stage (primary, secondary, etc...) whitin an Education System.
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
     * the collection of levels in this stage.
     *
     * @var \ArrayObject
     */
    private $levels;

    /**
     * Subjects in this stage
     * @var \ArrayObject
     */
    private $subjects;

    /**
     * The long name for this stage.
     *
     * @var string
     */
    private $name;

    /**
     * Short name for this stage.
     *
     * @var string
     */
    private $shortname;

    /**
     * Max number of levels in this stage. We need this to allow the building of the level collection.
     *
     * @var int
     */
    private $maxLevels;

    public function __construct(EducationSystem $system, Name $stage_name, Name $stage_short_name, $levels_in_stage)
    {
        $this->checkIsValidNumberOfLevels($levels_in_stage);
        $this->maxLevels = $levels_in_stage;
        $this->systen = $system;
        $this->name = $stage_name;
        $this->shortname = $stage_short_name;
        $this->levels = new \ArrayObject();
        $this->subjects = new \ArrayObject();
        $this->createAllNeccesaryLevels();
    }

    /**
     * Populates the level collection
     */
    private function createAllNeccesaryLevels()
    {
        for ($level = 1; $level <= $this->maxLevels; ++$level) {
            $this->levels->offsetSet($level, new EducationLevel($this, $level));
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

    public function getMaxLevels()
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

    public function addSubject(Name $subject_name, $optional = false, $levels = [])
    {
        $subject = new Subject($this, $subject_name, $optional, $levels);
        $this->subjects->offsetSet($subject_name, $subject);
    }

    private function checkIsValidNumberOfLevels($levels)
    {
        if ($levels == 0) {
            throw new \InvalidArgumentException(sprintf('There must be at leat one level in a stage. You specified %s.', $levels));
        }
    }
}

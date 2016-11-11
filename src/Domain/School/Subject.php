<?php

namespace Milhojas\Domain\School;

use Milhojas\Library\ValueObjects\Identity\Name;

/**
 * Represents a subject within a Stage in an Education System.
 */
class Subject
{
    /**
     * The name of the subject.
     *
     * @var string
     */
    private $name;

    /**
     * Flag meaning that this subject is optional.
     *
     * @var bool
     */
    private $optional;

    /**
     * Levels in which this subject exists.
     *
     * @var mixed array with levels where this subject is available
     */
    private $onlyThisLevels;

    /**
     * The stage to which this subject belongs.
     *
     * @var EducationStage
     */
    private $stage;

    /**
     * @param EducationStage $stage
     * @param Name           $subject_name
     * @param mixed          $optional
     * @param mixed          $onlyThisLevels
     */
    public function __construct(EducationStage $stage, Name $subject_name, $optional = false, $onlyThisLevels = [])
    {
        $this->stage = $stage;
        $this->name = $subject_name;
        $this->optional = $optional;
        $this->onlyThisLevels = $onlyThisLevels;
    }

    /**
     * Ask if this subject is optional for students.
     *
     * @return bool the subject is optional
     */
    public function isOptional()
    {
        return $this->optional;
    }

    /**
     * The name of the subject.
     *
     * @return Name|string the name of this subject
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return EducationStage
     */
    public function getStage()
    {
        return $this->stage;
    }

    /**
     * This subject is available in the level provided.
     *
     * @param mixed $level_to_check
     *
     * @return bool
     */
    public function existsInLevel($level_to_check)
    {
        if (! $this->onlyThisLevels) {
            return true;
        }
        return in_array($level_to_check, $this->onlyThisLevels);
    }

    public function createCourse($level)
    {
        if (! $this->existsInLevel($level)) {
            throw new \InvalidArgumentException(sprintf('"%s level is not valid for %s in stage %s"', $level, $this->name, $this->stage->getName()));
        }
        $course = new Course(
            $this,
            new EducationLevel($this->stage, $level));
        return $course;
    }

    public function __toString()
    {
        return sprintf('%s %s (%s)', $this->name, $this->stage->getName(), $this->stage->getSystem()->getName());
    }
}

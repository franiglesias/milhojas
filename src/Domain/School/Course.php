<?php


namespace Milhojas\Domain\School;
use Milhojas\Domain\School\Subject;
use Milhojas\Domain\School\EducationStage;
use Milhojas\Domain\School\EducationLevel;
use Milhojas\Domain\School\EducationSystem;

/**
 * Describes a Course
 */
class Course
{
    private $system;
    private $stage;
    private $subject;
    private $level;

    public function __construct(Subject $subject, EducationLevel $level)
    {
        $this->system = $subject->getStage()->getSystem();
        $this->stage = $subject->getStage();
        $this->level = $level;
        $this->subject = $subject;
        $this->name = sprintf(
            '%s %s %s (%s)',
            $this->subject->getName(),
            $this->level->getName(),
            $this->stage->getName(),
            $this->system->getName()
        );
    }

    public function getName()
    {
        return $this->name;
    }
}


 ?>

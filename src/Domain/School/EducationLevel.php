<?php

namespace Milhojas\Domain\School;

use Milhojas\Domain\School\EducationStage;

class EducationLevel {
    private $level;
    private $stage;

    public function __construct(EducationStage $stage, $level)
    {
        $this->stage = $stage;
        $this->checkIsValidLevel($level);
        $this->level = $level;
    }

    public function getShortName()
    {
        return sprintf('%1$s %2$s', $this->stage->getShortName(), $this->level);
    }

    public function getName()
    {
        return sprintf('%2$s %1$s', $this->stage->getName(), $this->level);
    }

    private function checkIsValidLevel($level)
    {
        if ($level > $this->stage->hasLevels()) {
            throw new \InvalidArgumentException(sprintf('Level %s doesn\'t exist in stage %s', $level, $this->stage->getShortName()));
        }
    }
}


 ?>

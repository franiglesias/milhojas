<?php

namespace Milhojas\Domain\School;
use Milhojas\Library\ValueObjects\Identity\Name;

/**
 * Represents a subject within a Stage in an Education System
 */
class Subject
{
    /**
     * The name of the subject
     *
     * @var string
     */
    private $name;

    /**
     * Flag meaning that this subject is optional
     *
     * @var Type
     */
    private $optional;

    private $levels;

    public function __construct(Name $subject_name, $optional = false, $levels = [])
    {
        $this->name = $subject_name;
        $this->optional = $optional;
        $this->levels = $levels;
    }

    public function isOptional()
    {
        return $this->optional;
    }

    public function getName()
    {
        return $this->name;
    }

    public function existsInLevel($level_to_check)
    {
        return in_array($level_to_check, $this->levels);
    }
}


 ?>

<?php

namespace Milhojas\Domain\School;

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

    public function __construct($subject_name, $optional = false)
    {
        $this->checkIsValidName($subject_name);
        $this->name = $subject_name;
        $this->optional = $optional;
    }

    private function checkIsValidName($name)
    {
        if (strlen($name) < 3) {
            throw new \InvalidArgumentException(sprintf('"%s" does not seem to be a good name for a subject.', $name));
        }
    }
}


 ?>

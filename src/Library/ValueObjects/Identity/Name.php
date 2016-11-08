<?php

namespace Milhojas\Library\ValueObjects\Identity;

/**
 * Represents a name that have at least some characters
 */
class Name
{
    const MINIMUM_LENGHT = 2;
    /**
     * The name
     *
     * @var string
     */
    private $name;

    public function __construct($name)
    {
        $this->checkIsName($name);
        $this->name = $name;
    }

    public function get()
    {
        return $this->name;
    }

    private function checkIsName($name_to_check)
    {
        if (strlen($name_to_check) < self::MINIMUM_LENGHT) {
            throw new \InvalidArgumentException(sprintf('"%s" seems to be a bad name for that.', $name_to_check));
        }
    }

    public function __toString()
    {
        return $this->name;
    }
}


 ?>

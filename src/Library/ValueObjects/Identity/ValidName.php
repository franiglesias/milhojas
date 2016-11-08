<?php

namespace Milhojas\Library\ValueObjects\Identity;

/**
 * Represents a name that have at least some characteristics
 */
class ValidName
{
    /**
     * The name
     *
     * @var string
     */
    private $name;

    public function __construct($name, $minimum_lenght = 3)
    {
        $this->checkIsValidName($name, $minimum_lenght);
        $this->name = $name;
    }

    public function get()
    {
        return $this->name;
    }

    private function checkIsValidName($name_to_check, $minimun_length)
    {
        if (strlen($name_to_check) < $minimun_length) {
            throw new \InvalidArgumentException(sprintf('"%s" seems to be a bad name for that.', $name_to_check));
        }
    }
}


 ?>

<?php

namespace Milhojas\Library\ValueObjects\Misc;

class Gender
{
    const MALE = 'male';
    const FEMALE = 'female';

    private $gender;

    public function __construct($gender)
    {
        $this->ensureValidGender($gender);
        $this->gender = $gender;
    }

    /**
     * @return string male|female
     */
    public function getGender()
    {
        return $this->gender;
    }

    private function ensureValidGender($gender)
    {
        if (!in_array($gender, [Gender::MALE, Gender::FEMALE])) {
            throw new \InvalidArgumentException(sprintf('%s is invalid value for Gender', $gender));
        }
    }
}

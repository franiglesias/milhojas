<?php

namespace Milhojas\Library\ValueObjects\Identity;

use Milhojas\Library\Sortable\Sortable;
use Milhojas\Library\ValueObjects\Misc\Gender;


class Person implements Sortable
{
    const MALE = 'm';
    const FEMALE = 'f';
    const LISTNAME = '%2$s, %1$s';
    const FULLNAME = '%1$s %2$s';

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $surname;
    /**
     * @var Gender
     */
    private $gender;

    public function __construct($name, $surname, Gender $gender)
    {
        $this->isNotEmpty($name);
        $this->isNotEmpty($surname);
        $this->name = $name;
        $this->surname = $surname;
        $this->gender = $gender;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getListName()
    {
        return sprintf(self::LISTNAME, $this->name, $this->surname);
    }

    public function getGender()
    {
        return $this->gender->getGender();
    }

    public function compare($other)
    {
        $collator = collator_create('es_ES');

        return collator_compare($collator, $this->getListName(), $other->getListName());
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function getFullName()
    {
        return sprintf(self::FULLNAME, $this->name, $this->surname);
    }

    private function isNotEmpty($name)
    {
        if (empty($name)) {
            throw new \InvalidArgumentException('A name and a last name must be provided for a Person');
        }
    }
}

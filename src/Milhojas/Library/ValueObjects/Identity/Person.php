<?php

namespace Milhojas\LIbrary\ValueObjects\Identity;

use Milhojas\Library\Sortable\Sortable;

class Person implements Sortable
{
    const MALE = 'm';
    const FEMALE = 'f';
    const LISTNAME = '%2$s, %1$s';
    const FULLNAME = '%1$s %2$s';

    private $name;
    private $surname;
    private $gender;

    public function __construct($name, $surname, $gender)
    {
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
}

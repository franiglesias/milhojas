<?php

namespace Milhojas\Library\ValueObjects\Identity;

use Milhojas\Library\Sortable\Sortable;

class PersonName implements Sortable
{
    private $name;
    private $surname;
    private $format;

    public function __construct($name, $surname)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->format = '%2$s, %1$s';
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function asListName()
    {
        return sprintf($this->format, $this->name, $this->surname);
    }
    /**
     * {@inheritdoc}
     */
    public function compare($object)
    {
        $collator = collator_create('es_ES');

        return collator_compare($collator, $this->asListName(), $object->asListName());
    }
}

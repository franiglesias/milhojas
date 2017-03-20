<?php

namespace Milhojas\Library\ValueObjects\Identity;

use Ramsey\Uuid\Uuid;

class Id
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public static function create()
    {
        $uuid4 = Uuid::uuid4();

        return new static($uuid4->toString());
    }

    public function __toString()
    {
        return $this->id;
    }
}

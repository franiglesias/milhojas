<?php

namespace spec\Milhojas\Infrastructure\Persistence\Storage;

use Milhojas\Infrastructure\Persistence\Storage\MemoryStorage;
use Milhojas\Infrastructure\Persistence\Storage\Storage;
use PhpSpec\ObjectBehavior;

class MemoryStorageSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(MemoryStorage::class);
        $this->shouldImplement(Storage::class);
    }

    public function it_stores_an_object($object)
    {
        $this->store($object);
        $this->findAll()->shouldHaveCount(1);
    }
}

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
}

<?php

namespace spec\Milhojas\Infrastructure\Persistence\Cantine;

use Milhojas\Domain\Cantine\CantineList\CantineSeat;
use Milhojas\Domain\Cantine\CantineList\CantineSeatRepository;
use Milhojas\Domain\Cantine\Specification\CantineSeatSpecification;
use Milhojas\Infrastructure\Persistence\Cantine\CantineSeatInMemoryRepository;
use PhpSpec\ObjectBehavior;

class CantineSeatInMemoryRepositorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(CantineSeatInMemoryRepository::class);
        $this->shouldImplement(CantineSeatRepository::class);
    }

    public function it_stores_and_finds_CantineSeat_objects(CantineSeat $cantineSeat1, CantineSeat $cantineSeat2, CantineSeatSpecification $specification)
    {
        $this->store($cantineSeat1);
        $this->store($cantineSeat2);
        $specification->isSatisfiedBy($cantineSeat1)->willReturn(true);
        $specification->isSatisfiedBy($cantineSeat2)->willReturn(false);
        $this->find($specification)->shouldBe([$cantineSeat1]);
    }
}

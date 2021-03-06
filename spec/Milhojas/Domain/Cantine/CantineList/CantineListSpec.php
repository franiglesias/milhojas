<?php

namespace spec\Milhojas\Domain\Cantine\CantineList;

use Milhojas\Domain\Cantine\CantineList\CantineList;
use Milhojas\Domain\Cantine\CantineList\CantineSeatListReporter;
use Milhojas\Domain\Cantine\CantineList\CantineSeat;
use Milhojas\Library\Sortable\Sortable;
use PhpSpec\ObjectBehavior;

class CantineListSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith();
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(CantineList::class);
        $this->shouldBeAnInstanceOf(\SplMinHeap::class);
    }

    public function it_stores_cantine_list_records(CantineSeat $cantineListRecord)
    {
        $this->insert($cantineListRecord);
    }

    public function it_has_smaller_at_top(CantineSeat $greater, CantineSeat $smaller)
    {
        $greater->compare($smaller)->willReturn(Sortable::GREATER);
        $smaller->compare($greater)->willReturn(Sortable::SMALLER);

        $this->insert($greater);
        $this->insert($smaller);
        $this->top();
        $this->current()->shouldBe($smaller);
    }

    public function it_accepts_cantine_list_reporters(CantineSeatListReporter $cantineListReporter)
    {
        $this->accept($cantineListReporter);
    }
}

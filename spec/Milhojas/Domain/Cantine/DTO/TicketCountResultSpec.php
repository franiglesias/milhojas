<?php

namespace spec\Milhojas\Domain\Cantine\DTO;

use Milhojas\Domain\Cantine\DTO\TicketCountResult;
use PhpSpec\ObjectBehavior;

class TicketCountResultSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(7.25, 7, 10);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(TicketCountResult::class);
    }

    public function it_can_get_total_count()
    {
        $this->getTotalCount()->shouldBe(10);
    }
    public function it_can_tell_total_income()
    {
        $this->getTotalIncome()->shouldBe(72.5);
    }

    public function it_can_get_paid_count_and_income()
    {
        $this->getPaidCount()->shouldBe(7);
        $this->getPaidIncome()->shouldBe(50.75);
    }

    public function it_can_get_pending_count_and_pending_income()
    {
        $this->getPendingCount()->shouldBe(3);
        $this->getPendingIncome()->shouldBe(21.75);
    }
}

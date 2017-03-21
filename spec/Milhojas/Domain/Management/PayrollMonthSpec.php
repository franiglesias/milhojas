<?php

namespace spec\Milhojas\Domain\Management;

use Milhojas\Domain\Management\PayrollMonth;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;


class PayrollMonthSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('01', '17');
        $this->shouldHaveType(PayrollMonth::class);
    }

    public function it_can_be_constructed_from_current_date()
    {
        $this->beConstructedThrough('current');
        $this->getFolderName()->shouldBe(date('Y/m'));
    }
}

<?php

namespace spec\Milhojas\Domain\Utils;

use Milhojas\Domain\Utils\RandomDaysSchedule;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RandomDaysScheduleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(RandomDaysSchedule::class);
    }
}

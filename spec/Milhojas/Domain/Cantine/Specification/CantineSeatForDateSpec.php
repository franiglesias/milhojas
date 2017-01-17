<?php

namespace spec\Milhojas\Domain\Cantine\Specification;

use Milhojas\Domain\Cantine\CantineList\CantineSeat;
use Milhojas\Domain\Cantine\Specification\CantineSeatForDate;
use Milhojas\Domain\Cantine\Specification\CantineSeatSpecification;
use PhpSpec\ObjectBehavior;

class CantineSeatForDateSpec extends ObjectBehavior
{
    private $date;

    public function let()
    {
        $this->date = new \DateTime('2016-11-12');
        $this->beConstructedWith($this->date);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(CantineSeatForDate::class);
        $this->shouldImplement(CantineSeatSpecification::class);
    }

    public function it_is_satisfied_by_CantineSeat_assigned_for_date(CantineSeat $cantineSeat)
    {
        $cantineSeat->getDate()->shouldBeCalled()->willReturn($this->date);
        $this->shouldBeSatisfiedBy($cantineSeat);
    }

    public function it_is_not_satisfied_by_CantineSeat_assigned_for_another_date(CantineSeat $cantineSeat)
    {
        $anotherDate = new \DateTime();
        $cantineSeat->getDate()->shouldBeCalled()->willReturn($anotherDate);
        $this->shouldNotBeSatisfiedBy($cantineSeat);
    }
}

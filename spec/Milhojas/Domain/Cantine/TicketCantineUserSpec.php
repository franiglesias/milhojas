<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\TicketCantineUser;
use Milhojas\Domain\Cantine\CantineUser;

use Milhojas\Domain\School\StudentId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TicketCantineUserSpec extends ObjectBehavior
{
    public function let(StudentId $student_id)
    {
        $days = [
            new \DateTime('11/14/2016'),
            new \DateTime('11/15/2016'),
            new \DateTime('12/15/2016')
        ];
        $this->beConstructedWith($student_id, $days);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TicketCantineUser::class);
    }

    public function it_is_CantineUser()
    {
        $this->shouldImplement('Milhojas\Domain\Cantine\CantineUser');
    }

    public function it_can_say_that_user_is_going_to_eat_on_a_date_reserved()
    {
        $this->shouldBeEatingOnDate(new \DateTime('11/14/2016'));
    }

    public function it_can_say_that_user_is_not_going_to_eat_on_a_date_not_reserved()
    {
        $this->shouldNotBeEatingOnDate(new \DateTime('11/16/2016'));
    }
}

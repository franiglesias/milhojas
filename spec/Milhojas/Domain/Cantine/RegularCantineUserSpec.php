<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\RegularCantineUser;
use Milhojas\Domain\School\StudentId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RegularCantineUserSpec extends ObjectBehavior
{
    public function let(StudentId $student_id)
    {
        $schedule = [
            'november' => ['monday', 'wednesday', 'friday'],
            'december' => ['tuesday', 'thursday']
        ];
        $this->beConstructedWith($student_id, $schedule);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(RegularCantineUser::class);
    }

    public function it_is_CantineUser()
    {
        $this->shouldImplement('Milhojas\Domain\Cantine\CantineUser');
    }


    public function it_can_say_if_user_is_going_to_eat_on_a_scheduled_date()
    {
        $this->shouldBeEatingOnDate(new \DateTime('11/14/2016'));
    }

    public function it_can_say_that_user_is_not_going_to_eat_on_a_day_not_suscripted()
    {
        $this->shouldNotBeEatingOnDate(new \DateTime('11/15/2016'));
    }

    public function it_can_say_that_user_is_not_going_to_eat_on_a_month_not_scheduled()
    {
        $this->shouldNotBeEatingOnDate(new \DateTime('1/15/2017'));
    }
}

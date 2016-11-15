<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\RegularCantineUser;
use Milhojas\Domain\School\StudentId;
use Milhojas\Domain\Utils\MonthWeekSchedule;
use PhpSpec\ObjectBehavior;

class RegularCantineUserSpec extends ObjectBehavior
{
    public function let(StudentId $student_id, MonthWeekSchedule $schedule)
    {
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

    public function it_can_say_if_user_is_going_to_eat_on_a_scheduled_date(MonthWeekSchedule $schedule, \DateTime $date)
    {
        $schedule->isScheduledDate($date)->shouldBeCalled();
        $schedule->isScheduledDate($date)->willReturn(true);
        $this->shouldBeEatingOnDate($date);
    }

    public function it_can_say_that_user_is_not_going_to_eat_on_a_day_not_suscripted(MonthWeekSchedule $schedule, \DateTime $date)
    {
        $schedule->isScheduledDate($date)->shouldBeCalled();
        $schedule->isScheduledDate($date)->willReturn(false);
        $this->shouldNotBeEatingOnDate($date);
    }

    public function it_can_say_that_user_is_not_going_to_eat_on_a_month_not_scheduled(MonthWeekSchedule $schedule, \DateTime $date)
    {
        $schedule->isScheduledDate($date)->shouldBeCalled();
        $schedule->isScheduledDate($date)->willReturn(false);
        $this->shouldNotBeEatingOnDate($date);
    }

    public function it_can_return_student_id(StudentId $student_id)
    {
        $this->getStudentId()->shouldReturn($student_id);
    }
}

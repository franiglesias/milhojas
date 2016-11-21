<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\Allergens;
use Milhojas\Domain\School\Student;
use Milhojas\Domain\School\StudentId;
use Milhojas\Domain\Utils\Schedule;
use PhpSpec\ObjectBehavior;

class CantineUserSpec extends ObjectBehavior
{
    public function let(Student $student, Schedule $schedule)
    {
        $this->beConstructedThrough('apply', [$student, $schedule]);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(CantineUser::class);
    }

    public function it_can_say_if_user_will_be_eating_on_date(Schedule $schedule)
    {
        $schedule->isScheduledDate(new \DateTime('11/15/2016'))->willReturn(true);
        $this->shouldBeEatingOnDate(new \DateTime('11/15/2016'));
    }

    public function it_can_say_to_which_student_is_associated(Student $student, StudentId $id)
    {
        $student->getStudentId()->willReturn($id);
        $this->getStudentId()->shouldReturn($id);
    }

    public function it_can_update_schedule(Schedule $schedule, Schedule $update_schedule, Schedule $final_schedule)
    {
        $schedule->update($update_schedule)->willReturn($final_schedule);
        $final_schedule->isScheduledDate(new \DateTime('11/15/2016'))->willReturn(false);
        $this->updateSchedule($update_schedule);
        $this->shouldNotBeEatingOnDate(new \DateTime('11/15/2016'));
    }

    public function it_knows_about_allergies(Allergens $allergens)
    {
        $this->updateAllergiesInformation($allergens);
    }
}

<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\CantineGroup;
use Milhojas\Domain\Cantine\NullCantineGroup;
use Milhojas\Domain\Cantine\Allergens;
use Milhojas\Domain\School\Student;
use Milhojas\Domain\School\StudentId;
use Milhojas\Domain\Utils\Schedule;
use PhpSpec\ObjectBehavior;

class CantineUserSpec extends ObjectBehavior
{
    public function let(Student $student, Schedule $schedule, StudentId $studentId)
    {
        $student->getStudentId()->willReturn($studentId);
        $this->beConstructedThrough('apply', [$student, $schedule]);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(CantineUser::class);
    }

    public function it_has_autoassigned_null_group_by_default()
    {
        $this->belongsToGroup(new NullCantineGroup())->shouldBe(true);
    }

    public function it_can_be_assigned_to_a_group()
    {
        $group = new CantineGroup('Group 1');
        $this->assignToGroup($group);
        $this->belongsToGroup($group)->shouldReturn(true);
    }

    public function it_can_say_if_user_will_be_eating_on_date(Schedule $schedule, \DateTime $anyDate)
    {
        $schedule->isScheduledDate($anyDate)->willReturn(true);
        $this->shouldBeEatingOnDate($anyDate);
    }

    public function it_can_say_to_which_student_is_associated(Student $student, StudentId $id)
    {
        $student->getStudentId()->willReturn($id);
        $this->getStudentId()->shouldReturn($id);
    }

    public function it_can_update_schedule(Schedule $schedule, Schedule $update_schedule, Schedule $final_schedule, \DateTime $anyDate)
    {
        $schedule->update($update_schedule)->willReturn($final_schedule);
        $final_schedule->isScheduledDate($anyDate)->willReturn(false);
        $this->updateSchedule($update_schedule);
        $this->shouldNotBeEatingOnDate($anyDate);
    }

    public function it_knows_about_allergies(Allergens $allergens)
    {
        $this->updateAllergiesInformation($allergens);
    }

    public function it_can_tell_extracurricular_user_is_enrolled()
    {
        $this->isEnrolled()->shouldReturn(true);
    }
}

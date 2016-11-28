<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\CantineGroup;
use Milhojas\Domain\Cantine\NullCantineGroup;
use Milhojas\Domain\School\Student;
use Milhojas\Domain\School\StudentId;
use Milhojas\Domain\Utils\Schedule\Schedule;
use Milhojas\Domain\Utils\Schedule\ListOfDates;
use Milhojas\Library\ValueObjects\Identity\PersonName;
use Milhojas\Library\Sortable\Sortable;
use PhpSpec\ObjectBehavior;

class CantineUserSpec extends ObjectBehavior
{
    public function let(Student $student, Schedule $schedule, StudentId $studentId, PersonName $name)
    {
        $student->getStudentId()->willReturn($studentId);
        $student->getName()->willReturn($name);

        $this->beConstructedThrough('apply', [$student, $schedule]);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(CantineUser::class);
        $this->shouldImplement(Sortable::class);
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

    public function it_can_compare_to_another_user(Student $anotherStudent, StudentId $anotherId, PersonName $anotherName, $name, $schedule)
    {
        $anotherStudent->getStudentId()->willReturn($anotherId);
        $anotherStudent->getName()->willReturn($anotherName);

        $name->compare($anotherName)->willReturn(-1)->shouldBeCalled();

        $another = CantineUser::apply(
            $anotherStudent->getWrappedObject(),
            $schedule->getWrappedObject()
        );
        $this->compare($another)->shouldBe(-1);
    }

    public function it_can_tell_extracurricular_user_is_enrolled()
    {
        $this->isEnrolled()->shouldReturn(true);
    }

    public function it_can_apply_without_schedule_getting_null_schedule($student, $studentId, $name, \DateTime $anyDate)
    {
        $this->beConstructedThrough('apply', [$student]);
        $this->shouldNotBeEatingOnDate($anyDate);
    }

    public function it_can_buy_a_ticket($student)
    {
        $date = new \DateTime();
        $this->beConstructedThrough('apply', [$student]);
        $this->buysTicketFor(new ListOfDates([$date]));
        $this->shouldBeEatingOnDate($date);
    }
}

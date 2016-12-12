<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\Allergens;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\CantineGroup;
use Milhojas\Domain\Cantine\NullCantineGroup;
use Milhojas\Domain\Cantine\Exception\InvalidTicket;
use Milhojas\Domain\Shared\Student;
use Milhojas\Domain\Shared\StudentId;
use Milhojas\Domain\Utils\Schedule\Schedule;
use Milhojas\Domain\Utils\Schedule\ListOfDates;
use Milhojas\Library\ValueObjects\Identity\Person;
use Milhojas\Library\Sortable\Sortable;
use PhpSpec\ObjectBehavior;

class CantineUserSpec extends ObjectBehavior
{
    public function let(Student $student, StudentId $studentId, Schedule $schedule, Person $name, Allergens $allergens)
    {
        $student->getId()->willReturn($studentId);
        $student->getPerson()->willReturn($name);
        $student->getAllergies()->willReturn($allergens);

        $this->beConstructedThrough('apply', [$student, $schedule]);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(CantineUser::class);
        $this->shouldImplement(Sortable::class);
    }

    public function it_can_tell_what_is_its_name($name)
    {
        $this->getPerson()->shouldHaveType(Person::class);
        $this->getPerson()->shouldBe($name);
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

        $schedule->isScheduledDate($anyDate)->willReturn(false);
        $this->shouldNotBeEatingOnDate($anyDate);
    }

    public function it_can_say_to_which_student_is_associated(StudentId $studentId)
    {
        $this->getStudentId()->shouldReturn($studentId);
    }

    public function it_can_update_schedule(Schedule $schedule, Schedule $delta, Schedule $new, \DateTime $anyDate)
    {
        $schedule->update($delta)
            ->shouldBeCalled()
            ->willReturn($new);

        $schedule->isScheduledDate($anyDate)->willReturn(true);
        $new->isScheduledDate($anyDate)
            ->willReturn(false);

        $this->updateSchedule($delta);
        $this->shouldNotBeEatingOnDate($anyDate);
    }

    public function it_can_compare_to_another_user($name, Person $anotherName, CantineUser $anotherUser)
    {
        $anotherUser->getPerson()->willReturn($anotherName);
        $name->compare($anotherName)->willReturn(-1)->shouldBeCalled();
        $this->compare($anotherUser)->shouldBe(-1);
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

    public function it_throws_exception_if_trying_to_buy_a_ticket_for_previously_scheduled_date($schedule)
    {
        $date = new \DateTime();
        $schedule->isScheduledDate($date)->willReturn(true);
        $this->shouldThrow(InvalidTicket::class)->during('buysTicketFor', [new ListOfDates([$date])]);
    }

    public function it_know_about_allergies($allergens)
    {
        $allergens->isAllergic()->willReturn(true);
        $this->shouldBeAllergic();

        $allergens->isAllergic()->willReturn(false);
        $this->shouldNotBeAllergic();
    }

    public function it_can_tell_allergens($allergens)
    {
        $this->getAllergens()->shouldBe($allergens);
    }
}

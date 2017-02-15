<?php

namespace spec\Milhojas\Domain\Cantine;

use League\Period\Period;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\CantineGroup;
use Milhojas\Domain\Cantine\NullCantineGroup;
use Milhojas\Domain\Cantine\Exception\InvalidTicket;
use Milhojas\Domain\Cantine\Allergens;
use Milhojas\Domain\Utils\Schedule\Schedule;
use Milhojas\Domain\Utils\Schedule\ListOfDates;
use Milhojas\Library\ValueObjects\Identity\Person;
use Milhojas\Library\Sortable\Sortable;
use PhpSpec\ObjectBehavior;

class CantineUserSpec extends ObjectBehavior
{
    public function let(Schedule $schedule)
    {
        $this->beConstructedThrough('apply', ['101', 'Pérez, Pedro', 'EP 3 A', 'EP', $schedule]);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(CantineUser::class);
        $this->shouldImplement(Sortable::class);
    }

    public function it_can_tell_what_is_its_name($name)
    {
        $this->getListName()->shouldBe('Pérez, Pedro');
    }

    public function it_has_autoassigned_null_group_by_default()
    {
        $this->belongsToGroup(new NullCantineGroup())->shouldBe(true);
    }

    public function it_can_be_assigned_to_a_group(CantineGroup $group)
    {
        $group->isTheSameAs($group)->willReturn(true);
        $this->assignToGroup($group);
        $this->belongsToGroup($group)->shouldReturn(true);
    }

    public function it_can_say_if_user_will_be_eating_on_date(Schedule $schedule, \DateTimeImmutable $anyDate)
    {
        $schedule->isScheduledDate($anyDate)->willReturn(true);
        $this->shouldBeEatingOnDate($anyDate);
    }

    public function it_can_say_user_will_not_be_eating_on_date(Schedule $schedule, \DateTimeImmutable $anyDate)
    {
        $schedule->isScheduledDate($anyDate)->willReturn(false);
        $this->shouldNotBeEatingOnDate($anyDate);
    }

    public function it_can_say_to_which_student_is_associated()
    {
        $this->getStudentId()->shouldReturn('101');
    }

    public function it_can_update_schedule(Schedule $schedule, Schedule $delta, Schedule $new, \DateTimeImmutable $anyDate)
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

    public function it_can_compare_to_another_user(CantineUser $anotherUser)
    {
        $anotherUser->getListName()->willReturn('Martínez, Eva');
        $this->compare($anotherUser)->shouldBe(1);
    }

    public function it_can_tell_extracurricular_user_is_enrolled()
    {
        $this->isEnrolled()->shouldReturn(true);
    }

    public function it_can_apply_without_schedule_getting_null_schedule(\DateTimeImmutable $anyDate)
    {
        $this->beConstructedThrough('apply', ['102', 'Fernández, Rodrigo', 'EP 4 B', 'EP']);
        $this->shouldNotBeEatingOnDate($anyDate);
    }

    public function it_can_buy_a_ticket()
    {
        $date = new \DateTime();
        $this->beConstructedThrough('apply', ['102', 'Fernández, Rodrigo', 'EP 4 B', 'EP']);
        $this->buysTicketFor(new ListOfDates([$date]));
        $this->shouldBeEatingOnDate($date);
    }

    public function it_throws_exception_if_trying_to_buy_a_ticket_for_previously_scheduled_date($schedule)
    {
        $date = new \DateTime();
        $schedule->isScheduledDate($date)->willReturn(true);
        $this->shouldThrow(InvalidTicket::class)->during('buysTicketFor', [new ListOfDates([$date])]);
    }

    public function it_know_about_allergies(Allergens $allergens)
    {
        $this->setAllergies($allergens);
        $allergens->isAllergic()->willReturn(true);
        $this->shouldBeAllergic();

        $allergens->isAllergic()->willReturn(false);
        $this->shouldNotBeAllergic();
    }

    public function it_can_tell_allergens(Allergens $allergens)
    {
        $this->setAllergies($allergens);
        $this->getAllergens()->shouldBe($allergens);
    }

    public function it_cant_tell_if_is_billable_on_month(Period $month, $schedule)
    {
        $schedule->scheduledDays($month)->willReturn(3);
        $this->shouldBeBillableOn($month);
        $this->getBillableDaysOn($month)->shouldBe(3);
    }

    public function it_can_tell_listname(Person $name)
    {
        $name->getListName()->willReturn('Pérez, Pedro');
        $this->getListName()->shouldBe('Pérez, Pedro');
    }

    public function it_can_tell_class_group_name()
    {
        $this->getClassGroupName()->shouldBe('EP 3 A');
    }

    public function it_can_tell_stage_name()
    {
        $this->getStageName()->shouldBe('EP');
    }

    public function it_can_tell_remarks()
    {
        $this->setRemarks('Some remarks');
        $this->getRemarks()->shouldBe('Some remarks');
    }
}

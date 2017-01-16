<?php

namespace spec\Milhojas\Domain\Utils\Schedule;

use Milhojas\Domain\Utils\Schedule\Schedule;
use Milhojas\Domain\Utils\Schedule\ListOfDates;
use Milhojas\Domain\Utils\Schedule\NullSchedule;
use League\Period\Period;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ListOfDatesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith([
            new \DateTime('11/16/2016'),
            new \DateTime('11/25/2016'),
        ]);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(ListOfDates::class);
        $this->shouldImplement(\IteratorAggregate::class);
    }

    public function it_ensures_schedule_has_valid_dates()
    {
        $this->beConstructedWith([
            '11/16/2016',
        ]);
        $this->shouldThrow('InvalidArgumentException')->duringInstantiation();
    }
    public function it_can_tell_if_a_date_is_a_scheduled_one()
    {
        $this->shouldBeScheduledDate(new \DateTime('11/16/2016'));
    }

    public function it_can_be_updated_with_another_schedule()
    {
        $updated = $this->update(new ListOfDates([
            new \DateTime('11/24/2016'),
            new \DateTime('12/25/2016'),
        ]));
        $updated->shouldBeScheduledDate(new \DateTime('11/24/2016'));
        $updated->shouldBeScheduledDate(new \DateTime('12/25/2016'));
        $updated->shouldBeScheduledDate(new \DateTime('11/16/2016'));
        $updated->shouldBeScheduledDate(new \DateTime('11/25/2016'));
    }

    public function it_accepts_unique_date()
    {
        $this->beConstructedWith(new \DateTime('11/14/2016'));
    }

    public function it_can_delegate_to_another_schedule_if_it_can_not_manage_a_date(Schedule $anotherSchedule)
    {
        $dateNotInOriginalSchedule = new \DateTime('11/15/2016');
        $anotherSchedule->isScheduledDate($dateNotInOriginalSchedule)->willReturn(true);
        $this->chain($anotherSchedule);
        $this->shouldBeScheduledDate($dateNotInOriginalSchedule);
    }

    public function it_cannot_update_with_a_schedule_of_another_type()
    {
        $this->shouldThrow(\InvalidArgumentException::class)->during('update', [new NullSchedule()]);
    }

    public function its_dates_are_accesible_as_an_array()
    {
        foreach ($this->getWrappedObject() as $date) {
            $this->shouldBeScheduledDate($date);
        }
    }

    public function it_does_not_have_scheduled_days(Period $period)
    {
        $this->scheduledDays($period)->shouldBe(0);
    }

    public function it_can_tell_real_days(Period $period)
    {
        $period->contains(Argument::any())->willReturn(true);
        $this->realDays($period)->shouldBe(2);
    }
}

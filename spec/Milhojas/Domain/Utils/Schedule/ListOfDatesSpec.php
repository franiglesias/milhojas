<?php

namespace spec\Milhojas\Domain\Utils\Schedule;

use Milhojas\Domain\Utils\Schedule\Schedule;
use Milhojas\Domain\Utils\Schedule\ListOfDates;
use PhpSpec\ObjectBehavior;

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

    public function it_can_add_new_dates()
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
        $this->setNext($anotherSchedule);
        $this->shouldBeScheduledDate($dateNotInOriginalSchedule);
    }
}

<?php

namespace spec\Milhojas\Domain\Utils\Schedule;

use Milhojas\Domain\Utils\Schedule\Schedule;
use Milhojas\Domain\Utils\Schedule\NullSchedule;
use Milhojas\Domain\Utils\Schedule\MonthWeekSchedule;
use League\Period\Period;
use PhpSpec\ObjectBehavior;

class MonthWeekScheduleSpec extends ObjectBehavior
{
    public function let()
    {
        $schedule = [
            'november' => ['monday', 'wednesday', 'friday'],
            'december' => ['tuesday', 'thursday'],
        ];
        $this->beConstructedWith($schedule);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(MonthWeekSchedule::class);
    }

    public function it_can_not_initialize_with_bad_data()
    {
        $schedule = array(
            'fake' => ['monday'],
        );
        $this->beConstructedWith($schedule);
        $this->shouldThrow('\InvalidArgumentException')->duringInstantiation();
    }

    public function it_detects_that_a_date_is_on_schedule()
    {
        $this->shouldBeScheduledDate(new \DateTime('11/14/2016'));
    }

    public function it_detects_that_a_date_is_not_on_schedule()
    {
        $this->shouldNotBeScheduledDate(new \DateTime('11/15/2016'));
    }

    public function it_can_update_schedule()
    {
        $changes = [
            'january' => ['tuesday', 'thursday'],
            'november' => ['monday', 'tuesday'],
        ];
        $updated = $this->update(new MonthWeekSchedule($changes));
        $updated->shouldBeScheduledDate(new \DateTime('11/14/2016'));
        $updated->shouldBeScheduledDate(new \DateTime('11/15/2016'));
        $updated->shouldBeScheduledDate(new \DateTime('01/10/2017'));
        $updated->shouldNotBeScheduledDate(new \DateTime('01/11/2017'));
    }

    public function it_is_immutable_for_update()
    {
        $changes = [
            'november' => ['monday', 'tuesday'],
        ];
        $this->update(new MonthWeekSchedule($changes));
        $this->shouldBeScheduledDate(new \DateTime('11/14/2016'));
        $this->shouldNotBeScheduledDate(new \DateTime('11/15/2016'));
    }

    public function it_can_delegate_to_another_schedule_if_it_can_not_manage_a_date(Schedule $anotherSchedule)
    {
        $dateNotInOriginalSchedule = new \DateTime('11/15/2016');
        $anotherSchedule->isScheduledDate($dateNotInOriginalSchedule)->willReturn(true);
        $this->setNext($anotherSchedule);
        $this->shouldBeScheduledDate($dateNotInOriginalSchedule);
    }

    public function it_can_not_update_with_a_schedule_of_another_type()
    {
        $this->shouldThrow(\InvalidArgumentException::class)->during('update', [new NullSchedule()]);
    }

    public function it_can_tell_scheduled_days(Period $period)
    {
        $period->getStartDate()->willReturn(new \DateTimeImmutable('11/1/2016'));
        $this->scheduledDays($period)->shouldBe(3);
    }
}

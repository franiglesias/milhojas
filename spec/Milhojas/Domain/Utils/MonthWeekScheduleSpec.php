<?php

namespace spec\Milhojas\Domain\Utils;

use Milhojas\Domain\Utils\MonthWeekSchedule;
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
            'january' => ['tuedsay', 'thursday'],
            'november' => ['monday', 'tuesday'],
        ];
        $updated = $this->update($changes);
        $updated->shouldBeScheduledDate(new \DateTime('11/14/2016'));
        $updated->shouldBeScheduledDate(new \DateTime('11/15/2016'));
        $updated->shouldBeScheduledDate(new \DateTime('01/10/2016'));
        $updated->shouldNotBeScheduledDate(new \DateTime('01/11/2016'));
    }

    public function it_can_reset_schedule()
    {
        $newSchedule = [
            'january' => ['tuedsay', 'thursday'],
            'november' => ['monday', 'tuesday'],
        ];
        $updated = $this->replace($newSchedule);
        $updated->shouldBeScheduledDate(new \DateTime('11/14/2016'));
        $updated->shouldBeScheduledDate(new \DateTime('11/15/2016'));
        // $updated->shouldBeScheduledDate(new \DateTime('01/10/2016'));
        // $updated->shouldNotBeScheduledDate(new \DateTime('01/11/2016'));
    }
}

<?php

namespace spec\Milhojas\Domain\Utils;

use Milhojas\Domain\Utils\RandomDaysSchedule;
use PhpSpec\ObjectBehavior;

class RandomDaysScheduleSpec extends ObjectBehavior
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
        $this->shouldHaveType(RandomDaysSchedule::class);
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
        $updated = $this->update(new RandomDaysSchedule([
            new \DateTime('11/24/2016'),
            new \DateTime('12/25/2016'),
        ]));
        $updated->shouldBeScheduledDate(new \DateTime('11/24/2016'));
        $updated->shouldBeScheduledDate(new \DateTime('12/25/2016'));
        $updated->shouldBeScheduledDate(new \DateTime('11/16/2016'));
        $updated->shouldBeScheduledDate(new \DateTime('11/25/2016'));
    }
}

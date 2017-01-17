<?php

namespace spec\Milhojas\Domain\Cantine\CantineList;

use Milhojas\Domain\Cantine\CantineList\TurnStageCantineSeatListReporter;
use Milhojas\Domain\Cantine\CantineList\CantineSeatListReporter;
use Milhojas\Domain\Cantine\CantineList\CantineSeat;
use PhpSpec\ObjectBehavior;

class TurnStageCantineSeatListReporterSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(TurnStageCantineSeatListReporter::class);
        $this->shouldBeAnInstanceOf(CantineSeatListReporter::class);
    }

    public function it_can_visit_records(CantineSeat $cantineListUserRecord)
    {
        $cantineListUserRecord->getTurnName()->shouldBeCalled();
        $cantineListUserRecord->getStageName()->shouldBeCalled();
        $this->visitRecord($cantineListUserRecord);
    }

    public function it_can_start_counting(CantineSeat $cantineListUserRecord)
    {
        $cantineListUserRecord->getTurnName()->willReturn('Turno 1');
        $cantineListUserRecord->getStageName()->willReturn('EP');
        $this->visitRecord($cantineListUserRecord);
        $this->getReport()->shouldBeLike(['Turno 1' => ['total' => 1, 'EP' => 1]]);
    }

    public function it_can_count_for_new_stage(CantineSeat $cantineListUserRecord, CantineSeat $cantineListUserRecord2)
    {
        $cantineListUserRecord->getTurnName()->willReturn('Turno 1');
        $cantineListUserRecord->getStageName()->willReturn('EP');
        $cantineListUserRecord2->getTurnName()->willReturn('Turno 1');
        $cantineListUserRecord2->getStageName()->willReturn('ESO');

        $this->visitRecord($cantineListUserRecord);
        $this->visitRecord($cantineListUserRecord2);
        $this->getReport()->shouldBeLike(['Turno 1' => ['total' => 2, 'EP' => 1, 'ESO' => 1]]);
    }

    public function it_can_count_for_new_turn(CantineSeat $cantineListUserRecord, CantineSeat $cantineListUserRecord2)
    {
        $cantineListUserRecord->getTurnName()->willReturn('Turno 1');
        $cantineListUserRecord->getStageName()->willReturn('EP');
        $cantineListUserRecord2->getTurnName()->willReturn('Turno 2');
        $cantineListUserRecord2->getStageName()->willReturn('EP');

        $this->visitRecord($cantineListUserRecord);
        $this->visitRecord($cantineListUserRecord2);
        $this->getReport()->shouldBeLike([
            'Turno 1' => ['total' => 1, 'EP' => 1],
            'Turno 2' => ['total' => 1, 'EP' => 1],
        ]);
    }

    public function it_can_totalize(CantineSeat $cantineListUserRecord, CantineSeat $cantineListUserRecord2)
    {
        $cantineListUserRecord->getTurnName()->willReturn('Turno 1');
        $cantineListUserRecord->getStageName()->willReturn('EP');
        $cantineListUserRecord2->getTurnName()->willReturn('Turno 2');
        $cantineListUserRecord2->getStageName()->willReturn('ESO');

        $this->visitRecord($cantineListUserRecord);
        $this->visitRecord($cantineListUserRecord2);
        $this->getTotal()->shouldBeLike([
            'all' => 2, 'EP' => 1, 'ESO' => 1,
        ]);
    }
}

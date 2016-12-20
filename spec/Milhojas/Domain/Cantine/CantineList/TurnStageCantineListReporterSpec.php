<?php

namespace spec\Milhojas\Domain\Cantine\CantineList;

use Milhojas\Domain\Cantine\CantineList\TurnStageCantineListReporter;
use Milhojas\Domain\Cantine\CantineList\CantineListReporter;
use Milhojas\Domain\Cantine\CantineList\CantineListUserRecord;
use Milhojas\Domain\Cantine\CantineList\CantineList;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TurnStageCantineListReporterSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->shouldHaveType(TurnStageCantineListReporter::class);
        $this->shouldBeAnInstanceOf(CantineListReporter::class);
    }

    public function it_can_visit_records(CantineListUserRecord $cantineListUserRecord, $otherClass)
    {
        $this->visitRecord($cantineListUserRecord);
    }

    public function it_can_visit_cantine_list(CantineList $cantineList)
    {
        $this->visitCantineList($cantineList);
    }

    public function it_can_start_counting(CantineListUserRecord $cantineListUserRecord)
    {
        $cantineListUserRecord->getTurnName()->willReturn('Turno 1');
        $cantineListUserRecord->getStageName()->willReturn('EP');
        $this->visitRecord($cantineListUserRecord);
        $this->getReport()->shouldBeLike(['Turno 1' => ['total' => 1, 'EP' => 1]]);
    }

    public function it_can_count_for_new_stage(CantineListUserRecord $cantineListUserRecord, CantineListUserRecord $cantineListUserRecord2)
    {
        $cantineListUserRecord->getTurnName()->willReturn('Turno 1');
        $cantineListUserRecord->getStageName()->willReturn('EP');
        $cantineListUserRecord2->getTurnName()->willReturn('Turno 1');
        $cantineListUserRecord2->getStageName()->willReturn('ESO');

        $this->visitRecord($cantineListUserRecord);
        $this->visitRecord($cantineListUserRecord2);
        $this->getReport()->shouldBeLike(['Turno 1' => ['total' => 2, 'EP' => 1, 'ESO' => 1]]);
    }

    public function it_can_count_for_new_turn(CantineListUserRecord $cantineListUserRecord, CantineListUserRecord $cantineListUserRecord2)
    {
        $cantineListUserRecord->getTurnName()->willReturn('Turno 1');
        $cantineListUserRecord->getStageName()->willReturn('EP');
        $cantineListUserRecord2->getTurnName()->willReturn('Turno 2');
        $cantineListUserRecord2->getStageName()->willReturn('EP');

        $this->visitRecord($cantineListUserRecord);
        $this->visitRecord($cantineListUserRecord2);
        $this->getReport()->shouldBeLike([
            'Turno 1' => ['total' => 1, 'EP' => 1],
            'Turno 2' => ['total' => 1, 'EP' => 1]
        ]);
    }

    public function it_can_totalize(CantineListUserRecord $cantineListUserRecord, CantineListUserRecord $cantineListUserRecord2)
    {
        $cantineListUserRecord->getTurnName()->willReturn('Turno 1');
        $cantineListUserRecord->getStageName()->willReturn('EP');
        $cantineListUserRecord2->getTurnName()->willReturn('Turno 2');
        $cantineListUserRecord2->getStageName()->willReturn('ESO');

        $this->visitRecord($cantineListUserRecord);
        $this->visitRecord($cantineListUserRecord2);
        $this->getTotal()->shouldBeLike([
            'all' => 2, 'EP' => 1, 'ESO' => 1
        ]);
    }


}

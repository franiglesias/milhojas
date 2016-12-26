<?php

namespace spec\Milhojas\Domain\Cantine\CantineList;

use Milhojas\Domain\Cantine\CantineList\CantineListUserRecord;
use Milhojas\Domain\Cantine\CantineList\SpecialMealsCantineListReporter;
use PhpSpec\ObjectBehavior;

class SpecialMealsCantineListReporterSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(SpecialMealsCantineListReporter::class);
    }

    public function it_can_visit_records(CantineListUserRecord $cantineListUserRecord)
    {
        $cantineListUserRecord->getRemarks()->shouldBeCalled()->willReturn('something');
        $cantineListUserRecord->getUserListName()->shouldBeCalled()->willReturn('something');
        $cantineListUserRecord->getTurnName()->shouldBeCalled()->willReturn('something');
        $this->visit($cantineListUserRecord);
    }

    public function it_visits_a_record_that_has_no_remarks(CantineListUserRecord $cantineListUserRecord)
    {
        $cantineListUserRecord->getRemarks()->shouldBeCalled()->willReturn('');
        $cantineListUserRecord->getUserListName()->shouldNotBeCalled();
        $this->visit($cantineListUserRecord);
    }

    public function it_can_tell_the_report(CantineListUserRecord $user1, CantineListUserRecord $user2, CantineListUserRecord $user3)
    {
        $user1->getRemarks()->willReturn('gluten');
        $user1->getUserListName()->willReturn('Pérez, Pedro');
        $user1->getTurnName()->willReturn('Turno 1');

        $user2->getRemarks()->willReturn('dieta blanda');
        $user2->getUserListName()->willReturn('Fernández, María');
        $user2->getTurnName()->willReturn('Turno 2');

        $user3->getRemarks()->willReturn('');
        $user3->getUserListName()->willReturn('López, Enrique');
        $user3->getTurnName()->willReturn('Turno 1');

        $this->visit($user1);
        $this->visit($user2);
        $this->visit($user3);

        $this->getReport()->shouldBeLike([
            ['turn' => 'Turno 1', 'user' => 'Pérez, Pedro', 'remarks' => 'gluten'],
            ['turn' => 'Turno 2', 'user' => 'Fernández, María', 'remarks' => 'dieta blanda'],
        ]);
    }
}

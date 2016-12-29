<?php

namespace spec\Milhojas\Domain\Cantine\CantineList;

use Milhojas\Domain\Cantine\CantineList\CantineListUserRecord;
use Milhojas\Domain\Cantine\CantineList\SpecialMealsCantineListReporter;
use Milhojas\Domain\Cantine\CantineList\SpecialMealsRecord;
use Milhojas\Domain\Cantine\CantineList\CantineListReporter;
use PhpSpec\ObjectBehavior;

class SpecialMealsCantineListReporterSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(SpecialMealsCantineListReporter::class);
        $this->shouldBeAnInstanceOf(CantineListReporter::class);
    }

    public function it_can_visit_records(CantineListUserRecord $cantineListUserRecord)
    {
        $cantineListUserRecord->getRemarks()->shouldBeCalled()->willReturn('something');
        $cantineListUserRecord->getUserListName()->shouldBeCalled()->willReturn('something');
        $cantineListUserRecord->getTurnName()->shouldBeCalled()->willReturn('something');
        $this->visitRecord($cantineListUserRecord);
    }

    public function it_visits_a_record_that_has_no_remarks(CantineListUserRecord $cantineListUserRecord)
    {
        $cantineListUserRecord->getRemarks()->shouldBeCalled()->willReturn('');
        $cantineListUserRecord->getUserListName()->shouldNotBeCalled();
        $this->visitRecord($cantineListUserRecord);
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

        $this->visitRecord($user1);
        $this->visitRecord($user2);
        $this->visitRecord($user3);
        $expected = [
            new SpecialMealsRecord('Turno 1', 'Pérez, Pedro', 'gluten'),
            new SpecialMealsRecord('Turno 2', 'Fernández, María', 'dieta blanda'),
        ];
        $this->getReport()->shouldBeLike($expected);
    }
}
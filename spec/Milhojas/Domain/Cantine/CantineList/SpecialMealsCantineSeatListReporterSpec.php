<?php

namespace spec\Milhojas\Domain\Cantine\CantineList;

use Milhojas\Domain\Cantine\CantineList\CantineSeat;
use Milhojas\Domain\Cantine\CantineList\SpecialMealsCantineSeatListReporter;
use Milhojas\Domain\Cantine\CantineList\SpecialMealsRecord;
use Milhojas\Domain\Cantine\CantineList\CantineSeatListReporter;
use PhpSpec\ObjectBehavior;

class SpecialMealsCantineSeatListReporterSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(SpecialMealsCantineSeatListReporter::class);
        $this->shouldBeAnInstanceOf(CantineSeatListReporter::class);
    }

    public function it_can_visit_records(CantineSeat $seat)
    {
        $seat->getRemarks()->shouldBeCalled()->willReturn('something');
        $seat->getUserListName()->shouldBeCalled()->willReturn('something');
        $seat->getTurnName()->shouldBeCalled()->willReturn('something');
        $this->visitRecord($seat);
    }

    public function it_visits_a_record_that_has_no_remarks(CantineSeat $seat)
    {
        $seat->getRemarks()->shouldBeCalled()->willReturn('');
        $seat->getUserListName()->shouldNotBeCalled();
        $this->visitRecord($seat);
    }

    public function it_can_tell_the_report(CantineSeat $user1, CantineSeat $user2, CantineSeat $user3)
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

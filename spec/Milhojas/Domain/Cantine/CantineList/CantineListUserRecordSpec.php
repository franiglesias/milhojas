<?php

namespace spec\Milhojas\Domain\Cantine\CantineList;

use Milhojas\Domain\Cantine\Turn;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\CantineList\CantineListUserRecord;
use Milhojas\Domain\Cantine\CantineList\CantineListReporter;
use Milhojas\Library\Sortable\Sortable;
use PhpSpec\ObjectBehavior;

class CantineListUserRecordSpec extends ObjectBehavior
{
    public function let(\DateTimeImmutable $date, CantineUser $user, Turn $turn)
    {
        // $this->beConstructedWith($date, $turn, $user);
        $this->beConstructedThrough('createFromUserTurnAndDate', [$user, $turn, $date]);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(CantineListUserRecord::class);
        $this->shouldImplement(Sortable::class);
    }

    public function it_can_tell_turn_name($turn)
    {
        $turn->getName()->willReturn('Turno 1');
        $this->getTurnName()->shouldBe('Turno 1');
    }

    public function it_can_tell_user_list_name($user)
    {
        $user->getListName()->willReturn('Pérez, Pedro');
        $this->getUserListName()->shouldBe('Pérez, Pedro');
    }

    public function it_can_tell_class_group_name($user)
    {
        $user->getClassGroupName()->willReturn('EP 4 A');
        $this->getClassGroupName()->shouldBe('EP 4 A');
    }

    public function it_can_tell_stage_name($user)
    {
        $user->getStageName()->willReturn('EP');
        $this->getStageName()->shouldBe('EP');
    }

    public function it_can_tell_remarks($user)
    {
        $user->getRemarks()->willReturn('Some remarks');
        $this->getRemarks()->shouldBe('Some remarks');
    }

    public function it_compares_using_student_when_date_and_turn_are_the_same(CantineListUserRecord $greater, $date, $turn, $user, CantineUser $greaterUser)
    {
        $greater->getDate()->willReturn($date);
        $greater->getTurn()->willReturn($turn);
        $greater->getUser()->willreturn($greaterUser);
        $user->compare($greaterUser)->willReturn(Sortable::SMALLER);
        $this->compare($greater)->shouldBe(Sortable::SMALLER);
    }

    public function it_compares_using_turn_when_dates_are_the_same(CantineListUserRecord $greater, $date, $turn, Turn $otherTurn, $user, CantineUser $otherUser)
    {
        $greater->getDate()->willReturn($date);
        $greater->getTurn()->willReturn($otherTurn);
        $greater->getUser()->willreturn($otherUser);
        $turn->compare($otherTurn)->willReturn(Sortable::GREATER);
        $this->compare($greater)->shouldBe(Sortable::GREATER);
    }

    public function it_can_accept_a_cantine_list_reporter(CantineListReporter $cantineListReporter)
    {
        $cantineListReporter->visitRecord($this->getWrappedObject())->shouldBeCalled();
        $this->accept($cantineListReporter);
    }
}

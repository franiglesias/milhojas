<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\Turn;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\CantineListRecord;
use Milhojas\Library\Sortable\Sortable;
use PhpSpec\ObjectBehavior;

class CantineListRecordSpec extends ObjectBehavior
{
    public function let(\DateTimeImmutable $date, CantineUser $user, Turn $turn)
    {
        $this->beConstructedWith($date, $turn, $user);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(CantineListRecord::class);
        $this->shouldImplement(Sortable::class);
    }

    public function it_compares_using_student_when_date_and_turn_are_the_same(CantineListRecord $greater, $date, $turn, $user, CantineUser $greaterUser)
    {
        $greater->getDate()->willReturn($date);
        $greater->getTurn()->willReturn($turn);
        $greater->getUser()->willreturn($greaterUser);
        $user->compare($greaterUser)->willReturn(Sortable::SMALLER);
        $this->compare($greater)->shouldBe(Sortable::SMALLER);
    }

    public function it_compares_using_turn_when_dates_are_the_same(CantineListRecord $greater, $date, $turn, Turn $otherTurn, $user, CantineUser $otherUser)
    {
        $greater->getDate()->willReturn($date);
        $greater->getTurn()->willReturn($otherTurn);
        $greater->getUser()->willreturn($otherUser);
        $turn->compare($otherTurn)->willReturn(Sortable::GREATER);
        $this->compare($greater)->shouldBe(Sortable::GREATER);
    }
}

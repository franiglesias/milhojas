<?php

namespace spec\Milhojas\Domain\Cantine\Event;

use Milhojas\Domain\Cantine\Event\UserWasAssignedToCantineTurn;
use Milhojas\Domain\Cantine\Turn;
use Milhojas\Domain\Cantine\CantineUser;
use PhpSpec\ObjectBehavior;

class UserWasAssignedToCantineTurnSpec extends ObjectBehavior
{
    public function it_is_initializable(CantineUser $user, Turn $turn, \DateTimeImmutable $date)
    {
        $this->beConstructedWith($user, $turn, $date);
        $this->shouldHaveType(UserWasAssignedToCantineTurn::class);
        $this->getUser()->shouldBe($user);
        $this->getTurn()->shouldBe($turn);
        $this->getDate()->shouldBe($date);
        $this->getName()->shouldBe('cantine.user_was_assigned_to_cantine_turn.event');
    }
}

<?php

namespace spec\Milhojas\Application\Cantine\Event;

use Milhojas\Application\Cantine\Event\UserWasAssignedToCantineTurn;
use Milhojas\Domain\Cantine\Turn;
use Milhojas\Domain\Cantine\CantineUser;
use PhpSpec\ObjectBehavior;

class UserWasAssignedToCantineTurnSpec extends ObjectBehavior
{
    public function it_is_initializable(CantineUser $user, Turn $turn, \DateTime $date)
    {
        $this->beConstructedWith($user, $turn, $date);
        $this->shouldHaveType(UserWasAssignedToCantineTurn::class);
        $this->getUser()->shouldBe($user);
        $this->getTurn()->shouldBe($turn);
        $this->getDate()->shouldBe($date);
        $this->getName()->shouldBe('milhojas.cantine.user_was_assigned_to_cantine_turn');
    }
}

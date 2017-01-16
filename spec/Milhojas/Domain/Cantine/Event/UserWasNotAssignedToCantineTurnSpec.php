<?php

namespace spec\Milhojas\Domain\Cantine\Event;

use Milhojas\Domain\Cantine\Event\UserWasNotAssignedToCantineTurn;
use Milhojas\Domain\Cantine\CantineUser;
use PhpSpec\ObjectBehavior;

class UserWasNotAssignedToCantineTurnSpec extends ObjectBehavior
{
    public function it_is_initializable(CantineUser $user, \DateTimeImmutable $date)
    {
        $this->beConstructedWith($user, $date);
        $this->shouldHaveType(UserWasNotAssignedToCantineTurn::class);
        $this->getUser()->shouldBe($user);
        $this->getDate()->shouldBe($date);
        $this->getName()->shouldBe('cantine.user_was_not_assigned_to_cantine_turn.event');
    }
}

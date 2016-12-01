<?php

namespace spec\Milhojas\Application\Cantine\Event;

use Milhojas\Application\Cantine\Event\UserWasNotAssignedToCantineTurn;
use Milhojas\Domain\Cantine\CantineUser;
use PhpSpec\ObjectBehavior;

class UserWasNotAssignedToCantineTurnSpec extends ObjectBehavior
{
    public function it_is_initializable(CantineUser $user, \DateTime $date)
    {
        $this->beConstructedWith($user, $date);
        $this->shouldHaveType(UserWasNotAssignedToCantineTurn::class);
        $this->getUser()->shouldBe($user);
        $this->getDate()->shouldBe($date);
        $this->getName()->shouldBe('milhojas.cantine.user_was_not_assigned_to_cantine_turn');
    }
}

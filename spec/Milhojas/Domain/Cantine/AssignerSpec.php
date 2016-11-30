<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\Assigner;
use Milhojas\Domain\Cantine\Rule;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\Rules;
use PhpSpec\ObjectBehavior;

class AssignerSpec extends ObjectBehavior
{
    private $fileSystem;

    public function let(Rules $rules, Rule $rule1)
    {
        $rules->getAll()->willReturn($rule1);
        $this->beConstructedWith($rule1);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Assigner::class);
    }

    public function it_assigns_turns(CantineUser $user1, CantineUser $user2, \DateTime $date, $rules, $rule1)
    {
        $rules->getAll()->shouldBeCalled();
        $rule1->assignsUserToTurn($user1, $date)->shouldBeCalled();
        $rule1->assignsUserToTurn($user2, $date)->shouldBeCalled();
        $this->assignUsersForDate([$user1, $user2], $date);
    }
}

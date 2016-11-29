<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\Assigner;
use Milhojas\Domain\Cantine\TurnRule;
use Milhojas\Domain\Cantine\Turn;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\Rules;
use PhpSpec\ObjectBehavior;

class AssignerSpec extends ObjectBehavior
{
    private $fileSystem;

    public function let(Rules $rules, TurnRule $rule1, TurnRule $rule2)
    {
        $rules->getAll()->willReturn($rule1);
        $this->beConstructedWith($rules);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Assigner::class);
    }

    public function it_assigns_turns(CantineUser $user1, CantineUser $user2, \DateTime $date, $rules)
    {
        $this->assignUsersForDate([$user1, $user2], $date);
    }

}

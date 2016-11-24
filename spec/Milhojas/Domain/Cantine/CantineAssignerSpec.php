<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\TurnRule;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\CantineAssigner;
use PhpSpec\ObjectBehavior;

class CantineAssignerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(CantineAssigner::class);
    }

    public function it_can_add_rules(TurnRule $rule1, TurnRule $rule2)
    {
        $this->addRule($rule1);
        $this->addRule($rule2);
        $this->countRules()->shouldBe(2);
    }

    public function it_can_generate_a_list_for_a_date(TurnRule $rule1, CantineUser $User1, TurnRule $rule2, CantineUser $User2, \DateTime $date)
    {
        $rule1->getAssignedTurn($User1, $date)->willReturn(1);
        $rule1->getAssignedTurn($User2, $date)->willReturn(null);
        $this->addRule($rule1);

        $rule2->getAssignedTurn($User1, $date)->willReturn(null);
        $rule2->getAssignedTurn($User2, $date)->willReturn(2);
        $this->addRule($rule2);

        $this->generateListFor($date, [$User1, $User2])->shouldBeArray();
    }
}

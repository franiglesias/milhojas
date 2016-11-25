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

    public function it_can_generate_a_list_for_a_date(TurnRule $rule1, CantineUser $User1, TurnRule $rule2, CantineUser $User2, TurnRule $rule3,  \DateTime $date)
    {
        $rule1->getAssignedTurn($User1, $date)->willReturn(1);
        $rule1->getAssignedTurn($User2, $date)->willReturn(2);

        $rule1->chain($rule2)->shouldBeCalled();
        // $rule2->chain($rule3)->shouldBeCalled();
        $this->addRule($rule1);
        $this->addRule($rule2);

        $list = $this->generateListFor($date, [$User1, $User2]);
        $list->shouldBeArray();
        $list->shouldHaveCount(2);
        $list[1][0]->shouldBe($User1);
        $list[2][0]->shouldBe($User2);
    }
}

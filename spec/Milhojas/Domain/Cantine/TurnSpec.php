<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\Turn;
use Milhojas\Domain\Cantine\CantineUser;
use PhpSpec\ObjectBehavior;

class TurnSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('Turn 1', 1);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(Turn::class);
    }

    public function it_is_an_iterator()
    {
        $this->shouldImplement(\IteratorAggregate::class);
    }

    public function it_has_a_name()
    {
        $this->getName()->shouldBe('Turn 1');
    }

    public function it_can_compare_with_others()
    {
        $this->shouldBeLessThan(new Turn('Turn 2', 2));
    }

    public function it_can_appoint_users(CantineUser $User1, CantineUser $User2, CantineUser $User3)
    {
        $this->appoint($User1);
        $this->appoint($User2);
        $this->appoint($User3);
        $this->shouldHaveCount(3);
    }

    public function it_can_sort_users(CantineUser $User1, CantineUser $User2, CantineUser $User3)
    {
        $User1->compare($User2)->willReturn(1);
        $User1->compare($User3)->willReturn(1);
        $User2->compare($User1)->willReturn(-1);
        $User2->compare($User3)->willReturn(-1);
        $User3->compare($User1)->willReturn(-1);
        $User3->compare($User2)->willReturn(1);
        $this->appoint($User1);
        $this->appoint($User2);
        $this->appoint($User3);
        $this->sort();
        $this[0]->shouldBe($User2);
        $this[1]->shouldBe($User3);
        $this[2]->shouldBe($User1);
    }
}

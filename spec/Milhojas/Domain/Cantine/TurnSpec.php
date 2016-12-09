<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\Turn;
use Milhojas\Domain\Cantine\CantineUser;
use PhpSpec\ObjectBehavior;
use Prophecy\Prophet;

class TurnSpec extends ObjectBehavior
{
    private $users;
    public function let()
    {
        $this->beConstructedWith('Turn 1', 1);
        $this->generateSomeUsers();
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

    public function it_can_appoint_users()
    {
        $this->appoint($this->users[0]);
        $this->appoint($this->users[1]);
        $this->appoint($this->users[2]);
        $this->shouldHaveCount(3);
    }

    public function it_can_sort_users()
    {
        $this->users[0]->compare($this->users[1])->willReturn(1);
        $this->users[0]->compare($this->users[2])->willReturn(1);
        $this->users[1]->compare($this->users[0])->willReturn(-1);
        $this->users[1]->compare($this->users[2])->willReturn(-1);
        $this->users[2]->compare($this->users[0])->willReturn(-1);
        $this->users[2]->compare($this->users[1])->willReturn(1);
        $this->appoint($this->users[0]);
        $this->appoint($this->users[1]);
        $this->appoint($this->users[2]);
        $this->sort();
        $this[0]->shouldBe($this->users[1]);
        $this[1]->shouldBe($this->users[2]);
        $this[2]->shouldBe($this->users[0]);
    }

    public function it_can_tell_if_it_has_user_appointed()
    {
        $this->appoint($this->users[0]);
        $this->shouldBeAppointed($this->users[0]);
        $this->shouldNotBeAppointed($this->users[1]);
    }

    private function generateSomeUsers()
    {
        $prophet = new Prophet();

        for ($i = 0; $i < 10; ++$i) {
            $user = $prophet->prophesize(CantineUser::class);
            $user->getStudentId()->willReturn('student-0'.$i);
            $this->users[] = $user;
        }
    }
}

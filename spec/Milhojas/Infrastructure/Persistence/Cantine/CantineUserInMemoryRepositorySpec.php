<?php

namespace spec\Milhojas\Infrastructure\Persistence\Cantine;

use Milhojas\Domain\Cantine\Exception\CantineUserNotFound;
use Milhojas\Infrastructure\Persistence\Cantine\CantineUserInMemoryRepository;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\CantineUserRepository;
use PhpSpec\ObjectBehavior;
use Milhojas\Domain\Cantine\Specification\AssociatedCantineUser;
use Milhojas\Domain\Cantine\Specification\CantineUserEatingOnDate;

class CantineUserInMemoryRepositorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(CantineUserInMemoryRepository::class);
        $this->shouldImplement(CantineUserRepository::class);
    }

    public function it_can_store_and_retrieve_a_cantine_user(CantineUser $cantineUser)
    {
        $cantineUser->getStudentId()->willReturn('student-01');
        $this->store($cantineUser);
        $this->retrieve('student-01')->shouldBe($cantineUser);
    }

    public function it_can_find_users_eating_today(\DateTimeImmutable $date, CantineUser $user1, CantineUser $user2, CantineUser $user3, CantineUser $user4, CantineUserEatingOnDate $specification)
    {
        $user1->getStudentId()->willReturn('student-01');
        $specification->isSatisfiedBy($user1)->shouldBeCalled()->willReturn(true);
        $user2->getStudentId()->willReturn('student-02');
        $specification->isSatisfiedBy($user2)->shouldBeCalled()->willReturn(false);
        $user3->getStudentId()->willReturn('student-03');
        $specification->isSatisfiedBy($user3)->shouldBeCalled()->willReturn(true);
        $user4->getStudentId()->willReturn('student-04');
        $specification->isSatisfiedBy($user4)->shouldBeCalled()->willReturn(false);

        $this->store($user1);
        $this->store($user2);
        $this->store($user3);
        $this->store($user4);
        $this->find($specification)->shouldReturn([$user1, $user3]);
    }

}

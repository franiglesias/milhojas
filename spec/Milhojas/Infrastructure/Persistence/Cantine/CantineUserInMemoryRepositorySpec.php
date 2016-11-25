<?php

namespace spec\Milhojas\Infrastructure\Persistence\Cantine;

use Milhojas\Infrastructure\Persistence\Cantine\CantineUserInMemoryRepository;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\CantineUserRepository;
use Milhojas\Domain\School\StudentId;
use PhpSpec\ObjectBehavior;

class CantineUserInMemoryRepositorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(CantineUserInMemoryRepository::class);
        $this->shouldBeAnInstanceOf(CantineUserRepository::class);
    }

    public function it_can_store_and_retrieve_a_cantine_user(CantineUser $cantineUser, StudentId $studentId)
    {
        $cantineUser->getStudentId()->willReturn($studentId);
        $this->store($cantineUser);
        $this->retrieve($studentId)->shouldBe($cantineUser);
    }

    public function it_can_build_a_list_of_users_eating_today(\DateTime $date, CantineUser $user1, CantineUser $user2, CantineUser $user3, CantineUser $user4)
    {
        $user1->getStudentId()->willReturn(new StudentId('student-01'));
        $user1->isEatingOnDate($date)->willReturn(true);
        $user2->getStudentId()->willReturn(new StudentId('student-02'));
        $user2->isEatingOnDate($date)->willReturn(false);
        $user3->getStudentId()->willReturn(new StudentId('student-03'));
        $user3->isEatingOnDate($date)->willReturn(true);
        $user4->getStudentId()->willReturn(new StudentId('student-04'));
        $user4->isEatingOnDate($date)->willReturn(false);
        $this->store($user1);
        $this->store($user2);
        $this->store($user3);
        $this->store($user4);
        $this->getUsersForDate($date)->shouldReturn([$user1, $user3]);
    }
}
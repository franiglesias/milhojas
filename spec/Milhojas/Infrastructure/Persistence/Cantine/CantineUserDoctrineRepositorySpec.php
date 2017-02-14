<?php

namespace spec\Milhojas\Infrastructure\Persistence\Cantine;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\CantineUserRepository;
use Milhojas\Infrastructure\Persistence\Cantine\CantineUserDoctrineRepository;
use Milhojas\Infrastructure\Persistence\Cantine\DTO\CantineUserDTO;
use PhpSpec\ObjectBehavior;
use Milhojas\Infrastructure\Persistence\Mapper\Mapper;

class CantineUserDoctrineRepositorySpec extends ObjectBehavior
{
    public function let(EntityManagerInterface $entityManager, Mapper $mapper)
    {
        $this->beConstructedWith($entityManager, $mapper);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(CantineUserDoctrineRepository::class);
        $this->shouldImplement(CantineUserRepository::class);
    }

    public function it_can_store_and_retrieve_a_cantine_user(CantineUser $cantineUser, Mapper $mapper, CantineUserDTO $dto, $entityManager)
    {
        $cantineUser->getStudentId()->willReturn('student-01');
        $mapper->entityToDto($cantineUser)->shouldBeCalled()->willReturn($dto);
        $entityManager->persist($dto)->shouldBeCalled();
        $entityManager->flush()->shouldBeCalled();
        $this->store($cantineUser);
    }

    public function it_can_retrieve_a_cantine_user_from_id(CantineUser $cantineUser, Mapper $mapper, CantineUserDTO $dto, EntityRepository $repository, $entityManager)
    {
        $entityManager->getRepository('Entity\CantineUser')->willReturn($repository);
        $repository->find('student-01')->shouldBeCalled()->willReturn($dto);
        $mapper->dtoToEntity($dto)->shouldBeCalled()->willReturn($cantineUser);
        $this->retrieve('student-01')->shouldBe($cantineUser);
    }
}

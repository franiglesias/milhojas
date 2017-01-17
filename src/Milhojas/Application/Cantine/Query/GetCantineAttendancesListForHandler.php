<?php

namespace Milhojas\Application\Cantine\Query;

use Milhojas\Domain\Cantine\CantineUserRepository;
use Milhojas\Domain\Cantine\Assigner;
use Milhojas\Domain\Cantine\Specification\CantineUserEatingOnDate;
use Milhojas\Library\Messaging\QueryBus\Query;
use Milhojas\Library\Messaging\QueryBus\QueryHandler;

class GetCantineAttendancesListForHandler implements QueryHandler
{
    /**
     * CantineUsers are stored here.
     *
     * @var CantineUserRepository
     */
    private $repository;
    /**
     * Assigns Users to their turns.
     *
     * @var Assigner
     */
    private $assigner;

    /**
     * @param CantineUserRepository $repository
     * @param Assigner              $assigner
     */
    public function __construct(CantineUserRepository $repository, Assigner $assigner)
    {
        $this->repository = $repository;
        $this->assigner = $assigner;
    }

    /**
     * {@inheritdoc}
     */
    public function answer(Query $query)
    {
        $list = $this->repository->find(new CantineUserEatingOnDate($query->getDate()));

        return $this->assigner->assign($query->getDate(), $list);
    }
}

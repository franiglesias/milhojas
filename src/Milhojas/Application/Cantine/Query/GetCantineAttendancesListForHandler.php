<?php

namespace Milhojas\Application\Cantine\Query;

use Milhojas\Domain\Cantine\CantineUserRepository;
use Milhojas\Domain\Cantine\Assigner;
use Milhojas\Domain\Cantine\CantineList\CantineList;
use Milhojas\Domain\Cantine\CantineList\CantineSeatRepository;
use Milhojas\Domain\Cantine\Specification\CantineSeatForDate;
use Milhojas\Messaging\QueryBus\Query;
use Milhojas\Messaging\QueryBus\QueryHandler;

class GetCantineAttendancesListForHandler implements QueryHandler
{
    /**
     * CantineUsers are stored here.
     *
     * @var CantineUserRepository
     */
    private $repository;

    /**
     * @param CantineSeatRepository $repository
     * @param Assigner              $assigner
     */
    public function __construct(CantineSeatRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function answer(Query $query)
    {
        $found = $this->repository->find(new CantineSeatForDate($query->getDate()));
        $cantineList = new CantineList();
        foreach ($found as $seat) {
            $cantineList->insert($seat);
        }

        return $cantineList;
    }
}

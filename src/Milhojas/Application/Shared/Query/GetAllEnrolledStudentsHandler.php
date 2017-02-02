<?php

namespace Milhojas\Application\Shared\Query;

use Milhojas\Messaging\QueryBus\Query;
use Milhojas\Messaging\QueryBus\QueryHandler;
use Milhojas\Domain\Shared\StudentServiceRepository;

class GetAllEnrolledStudentsHandler implements QueryHandler
{
    /**
     * @var StudentServiceRepository
     */
    private $repository;

    public function __construct(StudentServiceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function answer(Query $query)
    {
        $results = $this->repository->getAll();

        return $results;
    }
}

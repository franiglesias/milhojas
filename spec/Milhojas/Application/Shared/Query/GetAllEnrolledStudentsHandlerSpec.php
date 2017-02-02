<?php

namespace spec\Milhojas\Application\Shared\Query;

use Milhojas\Application\Shared\Query\GetAllEnrolledStudentsHandler;
use Milhojas\Application\Shared\Query\GetAllEnrolledStudents;
use Milhojas\Domain\Shared\StudentServiceRepository;
use Milhojas\Messaging\QueryBus\QueryHandler;
use PhpSpec\ObjectBehavior;

class GetAllEnrolledStudentsHandlerSpec extends ObjectBehavior
{
    public function let(StudentServiceRepository $repository)
    {
        $this->beConstructedWith($repository);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(GetAllEnrolledStudentsHandler::class);
        $this->shouldImplement(QueryHandler::class);
    }

    public function it_answers_the_GetAllEnrolledStudents_query(GetAllEnrolledStudents $query, $repository)
    {
        $repository->getAll()->shouldBeCalled()->willReturn(['student1', 'student2']);
        $this->answer($query)->shouldBe(['student1', 'student2']);
    }
}

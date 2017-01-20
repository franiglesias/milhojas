<?php

namespace spec\Milhojas\Library\Messaging\QueryBus;

use Milhojas\Library\Messaging\QueryBus\Query;
use Milhojas\Library\Messaging\QueryBus\QueryBus;
use Milhojas\Library\Messaging\Shared\Pipeline\Pipeline;
use Milhojas\Library\Messaging\Shared\Worker\Worker;
use PhpSpec\ObjectBehavior;

class QueryBusSpec extends ObjectBehavior
{
    public function let(Pipeline $pipeline)
    {
        $this->beConstructedWith($pipeline);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(QueryBus::class);
    }

    public function it_dispatches_queries_through_the_pipeline_and_get_the_response(Query $query, $pipeline)
    {
        $pipeline->work($query)->shouldBeCalled()->willReturn('Response');
        $this->execute($query)->shouldBe('Response');
    }

    public function it_accepts_a_unique_worker(Worker $worker, Query $query)
    {
        $this->beConstructedWith($worker);
        $worker->work($query)->shouldBeCalled()->willReturn('Response');
        $this->execute($query)->shouldBe('Response');
    }
}

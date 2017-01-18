<?php

namespace spec\Milhojas\Library\Messaging\QueryBus;

use Milhojas\Library\Messaging\QueryBus\QueryBus;
use Milhojas\Library\Messaging\QueryBus\Query;
use Milhojas\Library\Messaging\Shared\Worker\MessageWorker;
use PhpSpec\ObjectBehavior;

class QueryBusSpec extends ObjectBehavior
{
    public function let(MessageWorker $worker1, MessageWorker $worker2, MessageWorker $worker3)
    {
        $worker1->chain($worker2)->shouldBeCalled();
        $worker1->chain($worker3)->shouldBeCalled();
        $this->beConstructedWith([$worker1, $worker2, $worker3]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(QueryBus::class);
    }

    public function it_executes_a_query_passing_it_to_all_workers_in_order_and_returning_responeg_response(Query $query, $worker1, $worker2, $worker3)
    {
        $worker1->work($query)->shouldBeCalled()->willReturn('The Result');
        $this->execute($query)->shouldBe('The Result');
    }
}

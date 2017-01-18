<?php

namespace spec\Milhojas\Library\Messaging\QueryBus\Worker;

use Milhojas\Library\Messaging\QueryBus\QueryHandler;
use Milhojas\Library\Messaging\QueryBus\Query;
use Milhojas\Library\Messaging\QueryBus\Worker\QueryWorker;
use Milhojas\Library\Messaging\Shared\Worker\MessageWorker;
use PhpSpec\ObjectBehavior;
use Milhojas\Library\Messaging\Shared\Loader\Loader;
use Milhojas\Library\Messaging\Shared\Inflector\Inflector;
use Prophecy\Argument;

class QueryWorkerSpec extends ObjectBehavior
{
    public function let(Loader $loader, Inflector $inflector)
    {
        $this->beConstructedWith($loader, $inflector);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(QueryWorker::class);
        $this->shouldBeAnInstanceOf(MessageWorker::class);
    }

    public function it_performs_query_and_returns_result(Query $query, QueryHandler $handler, $loader, $inflector)
    {
        $inflector->inflect(Argument::type('string'))->shouldBeCalled()->willReturn('Handler');
        $loader->get('Handler')->shouldBeCalled()->willReturn($handler);
        $handler->answer($query)->shouldBeCalled()->willReturn('A result');
        $this->execute($query)->shouldBe('A result');
    }
}

<?php

namespace spec\Milhojas\Library\QueryBus;

use Milhojas\Library\QueryBus\SimpleQueryBus;
use Milhojas\Library\QueryBus\QueryBus;
use Milhojas\Library\QueryBus\Query;
use Milhojas\Library\QueryBus\QueryHandler;
use Milhojas\Library\QueryBus\Loader\Loader;
use Milhojas\Library\QueryBus\Inflector\Inflector;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SimpleQueryBusSpec extends ObjectBehavior
{
    public function let(Loader $loader, Inflector $inflector)
    {
        $this->beConstructedWith($loader, $inflector);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(SimpleQueryBus::class);
        $this->shouldImplement(QueryBus::class);
    }

    public function it_can_execute_Query_returning_result($loader, $inflector, Query $query, QueryHandler $handler)
    {
        $handler->answer($query)->willReturn('Query executed!');
        $inflector->inflect(Argument::type('string'))->shouldBeCalled();
        $loader->get(Argument::any())->willReturn($handler);

        $this->execute($query)->shouldBe('Query executed!');
    }
}

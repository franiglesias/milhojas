<?php

namespace spec\Milhojas\Library\QueryBus\Loader;

use Milhojas\Library\QueryBus\QueryHandler;
use Milhojas\Library\QueryBus\Loader\TestLoader;
use Milhojas\Library\QueryBus\Loader\Loader;
use Milhojas\Library\QueryBus\Exception\InvalidLoaderKey;
use PhpSpec\ObjectBehavior;

class TestLoaderSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(TestLoader::class);
        $this->shouldImplement(Loader::class);
    }

    public function it_loads_class_given_by_name(QueryHandler $handler)
    {
        $this->add('context.my_query.handler', $handler);
        $this->get('context.my_query.handler')->shouldBe($handler);
    }

    public function it_throws_exception_if_no_handler_found()
    {
        $this->shouldThrow(InvalidLoaderKey::class)->during('get', ['context.my_query.handler']);
    }
}

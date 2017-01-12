<?php

namespace spec\Milhojas\Library\Messaging\Shared\Loader;

use Milhojas\Library\Messaging\QueryBus\QueryHandler;
use Milhojas\Library\Messaging\Shared\Loader\TestLoader;
use Milhojas\Library\Messaging\Shared\Loader\Loader;
use Milhojas\Library\Messaging\Shared\Exception\InvalidLoaderKey;
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

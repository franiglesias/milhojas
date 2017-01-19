<?php

namespace spec\Milhojas\Library\Messaging\Shared;

use Milhojas\Library\Messaging\Shared\Message;
use Milhojas\Library\Messaging\Shared\WorkerPipeline;
use Milhojas\Library\Messaging\Shared\Worker\MessageWorker;
use PhpSpec\ObjectBehavior;

class WorkerPipelineSpec extends ObjectBehavior
{
    public function let(MessageWorker $worker1, MessageWorker $worker2)
    {
        $worker1->chain($worker2)->shouldBeCalled();
        $this->beConstructedWith([$worker1, $worker2]);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(WorkerPipeline::class);
    }

    public function it_works_with_a_message(Message $message, $worker1)
    {
        $worker1->work($message)->shouldBeCalled();
        $this->work($message);
    }

    public function it_works_with_a_message_and_returns_a_reponse(Message $message, $worker1)
    {
        $worker1->work($message)->shouldBeCalled()->willReturn('Response');
        $this->work($message)->shouldBe('Response');
    }
}

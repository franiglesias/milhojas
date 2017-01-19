<?php

namespace spec\Milhojas\Library\Messaging\Shared\Worker;

use Milhojas\Library\Messaging\CommandBus\Command;
use Milhojas\Library\Messaging\EventBus\Event;
use Milhojas\Library\Messaging\QueryBus\Query;
use Milhojas\Library\Messaging\Shared\Worker\LoggerWorker;
use Milhojas\Library\Messaging\Shared\Message;
use Milhojas\Library\Messaging\Shared\Worker\MessageWorker;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Log\LoggerInterface;

class LoggerWorkerSpec extends ObjectBehavior
{
    public function let(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(LoggerWorker::class);
        $this->shouldBeAnInstanceOf(MessageWorker::class);
    }

    public function it_logs_a_message(Message $message, $logger)
    {
        $logger->notice(Argument::that(function ($string) {
            return preg_match('/\.message/', $string);
        }))->shouldBeCalled();
        $this->execute($message);
    }

    public function it_logs_a_command(Command $command, $logger)
    {
        $logger->notice(Argument::that(function ($string) {
            return preg_match('/\.command/', $string);
        }))->shouldBeCalled();
        $this->execute($command);
    }

    public function it_logs_a_query(Query $query, $logger)
    {
        $logger->notice(Argument::that(function ($string) {
            return preg_match('/\.query/', $string);
        }))->shouldBeCalled();
        $this->execute($query);
    }

    public function it_logs_an_event(Event $event, $logger)
    {
        $logger->notice(Argument::that(function ($string) {
            return preg_match('/\.event/', $string);
        }))->shouldBeCalled();
        $this->execute($event);
    }
}

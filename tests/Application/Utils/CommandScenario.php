<?php

namespace Tests\Application\Utils;

# Application Messaging


use Milhojas\Messaging\CommandBus\Command;
use Milhojas\Messaging\CommandBus\CommandHandler;
use Milhojas\Messaging\CommandBus\TestCommandBus;
use Milhojas\Messaging\EventBus\EventRecorder;
use PHPUnit\Framework\TestCase;


/**
 * Base class for test Command/CommandHandler scenarios.
 * Extend this to get a Testcase with fluent interface and dummy messaging structure
 *
 * @package default
 * @author  Fran Iglesias
 */
class CommandScenario extends TestCase
{
    /**
     * @var Command
     */
    protected $command;
    /**
     * @var EventRecorder
     */
    protected $recorder;
    /**
     * @var TestCommandBus
     */
    protected $bus;
    /**
     * @var TestEventBus
     */
    protected $dispatcher;

    /**
     * Always call parent::setUp()
     *
     * @return void
     * @author Fran Iglesias
     */
    public function setUp()
    {
        $this->recorder = new EventRecorder();
        $this->bus = new TestCommandBus();
        $this->dispatcher = new TestEventBus();
    }

    /**
     * The Command we are testing
     *
     * @param Command $command
     *
     * @return void
     * @author Fran Iglesias
     */
    protected function sending(Command $command)
    {
        $this->command = $command;

        return $this;
    }

    /**
     * The handler we are testing
     *
     * @param CommandHandler $handler
     *
     * @return void
     * @author Fran Iglesias
     */
    protected function toHandler(CommandHandler $handler)
    {
        $handler->handle($this->command);

        return $this;
    }

    /**
     * Synonym
     *
     * @param CommandHandler $handler
     *
     * @return void
     * @author Fran Iglesias
     */
    protected function to(CommandHandler $handler)
    {
        return $this->toHandler($handler);
    }

    /**
     * Asserts if this event is raised to the Event Recorder
     *
     * @param string $eventName
     *
     * @return void
     * @author Fran Iglesias
     */
    protected function raisesEvent($eventName)
    {
        $this->assertTrue($this->dispatcher->wasDispatched($eventName));

        return $this;
    }

    /**
     * $effect is the boolean result of some checking in other objects in the test
     * like MailerStub or whatever you can check as boolean
     *
     * @param boolean $effect
     *
     * @return self
     * @author Fran Iglesias
     */
    protected function produces($effect)
    {
        if (is_bool($effect)) {
            $this->assertTrue($effect);
        }


        return $this;
    }

    /**
     * Asserts id this Command was sent
     *
     * @param string $command
     *
     * @return void
     * @author Fran Iglesias
     */
    protected function sendsCommand($command, $times = 1)
    {
        $this->assertTrue($this->bus->wasReceived($command, $times), sprintf('%s command not sent.', $command));

        return $this;
    }


    protected function producesCommandHistory($expected)
    {
        $this->assertEquals($expected, $this->bus->getReceived());

        return $this;
    }


    protected function producesEventHistory($expected)
    {
        $this->assertEquals($expected, $this->dispatcher->getHistory());

        return $this;
    }

}

?>

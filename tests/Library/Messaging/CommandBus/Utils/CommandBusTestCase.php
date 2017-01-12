<?php

namespace Tests\Library\Messaging\CommandBus\Utils;

use Milhojas\Library\Messaging\CommandBus\CommandBus;
use Milhojas\Library\Messaging\CommandBus\Command;

class CommandBusTestCase extends \PHPUnit_Framework_Testcase
{
    private $busUnderTest;

    protected function withBus(CommandBus $busUnderTest)
    {
        $this->busUnderTest = new CommandBusSpy($busUnderTest);

        return $this;
    }

    protected function sendingCommand(Command $command)
    {
        $this->busUnderTest->execute($command);

        return $this;
    }

    protected function producesPipeline(array $expectedPipeline)
    {
        $this->assertEquals($expectedPipeline, $this->busUnderTest->getPipeline());

        return $this;
    }

    protected function executes(array $expectedExecution)
    {
        $this->assertEquals($expectedExecution, $this->busUnderTest->getCommandsExecuted());
    }
}

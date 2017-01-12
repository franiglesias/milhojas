<?php

namespace Tests\Library\Messaging\CommandBus;

use Milhojas\Library\Messaging\CommandBus\CommandBus;
use Tests\Library\Messaging\CommandBus\Utils\CommandBusTestCase;
use Tests\Library\Messaging\CommandBus\Fixtures\ExecuteCommandFakeWorker;
use Tests\Library\Messaging\CommandBus\Fixtures\IntactCommandFakeWorker;
use Tests\Library\Messaging\CommandBus\Fixtures\SimpleCommand;

class BasicCommandBusTest extends CommandBusTestCase
{
    public function test_executes_a_command_passing_trough_loaded_command_workers()
    {
        $this->withBus(new CommandBus([
                    new IntactCommandFakeWorker(),
                    new ExecuteCommandFakeWorker(),
                    new IntactCommandFakeWorker(),
                ]))
                ->sendingCommand(new SimpleCommand('Message 1'))
                ->producesPipeline([
                    'IntactCommandFakeWorker',
                    'ExecuteCommandFakeWorker',
                    'IntactCommandFakeWorker',
                ])
                ->executes(['SimpleCommand']);
    }
}

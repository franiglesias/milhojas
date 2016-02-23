<?php

namespace Milhojas\Library\CommandBus\Workers;

use Milhojas\Library\CommandBus\Command;

interface CommandWorker {
	public function execute(Command $command);
}

?>
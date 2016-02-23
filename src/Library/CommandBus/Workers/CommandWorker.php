<?php

namespace Milhojas\Library\CommandBus\Workers;

use Milhojas\Library\CommandBus\Command;

interface CommandWorker {
	public function setNext(CommandWorker $next);
	public function execute(Command $command);
}

?>
<?php

namespace Milhojas\Library\CommandBus\Workers;

use Milhojas\Library\CommandBus\Command;

interface ChainableCommandWorker {
	public function setNext(ChainableCommandWorker $next);
	public function execute(Command $command);
}

?>

<?php

namespace Milhojas\Library\Messaging\CommandBus\Workers;

use Milhojas\Library\Messaging\CommandBus\Command;

interface ChainableCommandWorker {
	public function setNext(ChainableCommandWorker $next);
	public function execute(Command $command);
}

?>

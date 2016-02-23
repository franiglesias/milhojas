<?php

namespace Milhojas\Library\CommandBus;

interface CommandWorker {
	public function execute(Command $command);
}

?>
<?php

namespace Milhojas\Library\Messaging\CommandBus;

interface CommandBus {
	public function execute(Command $command);
}

?>

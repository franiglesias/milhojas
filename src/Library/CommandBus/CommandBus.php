<?php

namespace Milhojas\Library\CommandBus;

interface CommandBus {
	public function execute(Command $command);
}

?>

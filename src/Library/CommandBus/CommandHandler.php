<?php

namespace Milhojas\Library\CommandBus;

interface CommandHandler {
	public function handle(Command $command);
}

?>

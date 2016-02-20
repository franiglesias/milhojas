<?php

namespace Milhojas\Library\CommandBus;

use Milhojas\Library\CommandBus\Command;

interface Inflector {
	public function inflect(Command $command);
}

?>
<?php

namespace Milhojas\Library\CommandBus\Inflectors;

use Milhojas\Library\CommandBus\Command;

interface Inflector {
	public function inflect(Command $command);
}

?>
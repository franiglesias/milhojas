<?php

namespace Milhojas\Library\Messaging\CommandBus\Containers;

interface Container {
	public function make($classname);
}

?>

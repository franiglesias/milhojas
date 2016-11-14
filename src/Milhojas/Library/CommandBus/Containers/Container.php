<?php

namespace Milhojas\Library\CommandBus\Containers;

interface Container {
	public function make($classname);
}

?>

<?php

namespace Milhojas\Library\CommandBus;

interface Container {
	public function make($classname);
}

?>
<?php

namespace Milhojas\Application;

interface Container {
	public function make($classname);
}

?>
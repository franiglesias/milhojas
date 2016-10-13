<?php

namespace Milhojas\Infrastructure\Templating;

interface template {
	public function renderBlock($block, $parameters = array());
}
?>

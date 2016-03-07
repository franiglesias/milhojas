<?php

namespace Tests\Utils;

use Milhojas\Infrastructure\Templating\Templating;
use Tests\Utils\TemplateStub;

class TemplatingStub implements Templating {
	
	public function loadTemplate($template)
	{
		return new TemplateStub($template);
	}
}

?>
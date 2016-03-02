<?php

namespace Tests\Utils;

use Milhojas\Infrastructure\Templating\Template;

class TemplateStub implements Template {
	
	private $template;
	
	public function __construct($template)
	{
		$this->template = $template;
	}
	
	public function renderBlock($block, $parameters = array())
	{
		return sprintf('Block %s of template %s rendered.', $block, $this->template);
	}
}

?>
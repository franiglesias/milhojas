<?php

namespace Milhojas\Infrastructure\Templating\Adapters;

use Milhojas\Infrastructure\Templating\Template;

class TwigTemplate implements Template {
	
	private $twigTemplate;
	
	public function __construct($twigTemplate)
	{
		$this->twigTemplate = $twigTemplate;
	}
	
	public function renderBlock($block, $parameters = array())
	{
		return $this->twigTemplate->renderBlock($block, $parameters);
	}
}

?>
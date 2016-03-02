<?php

namespace Milhojas\Infrastructure\Templating\Adapters;

use Milhojas\Infrastructure\Templating\Templating;

class TwigTemplating implements Templating {
	
	private $twig;
	
	public function __construct($twig)
	{
		$this->twig = $twig;
	}
	
	public function loadTemplate($template)
	{
		return $this->twig->loadTemplate($template);
	}
	
	
	// public function __call($method, $args)
	// {
	// 	return call_user_func_array(array($this->twig, $method), $args);
	// }
}

?>
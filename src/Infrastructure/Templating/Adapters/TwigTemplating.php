<?php

namespace Milhojas\Infrastructure\Templating\Adapters;

use Milhojas\Infrastructure\Templating\Templating;

/**
 * Adaptaer for Templating
 *
 * @package default
 * @author Fran Iglesias
 */

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
}

?>
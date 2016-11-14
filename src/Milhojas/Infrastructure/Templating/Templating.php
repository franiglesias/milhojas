<?php

namespace Milhojas\Infrastructure\Templating;

/**
 * Interface for decoupling template systems
 * 
 * It is based on Twig
 *
 * @package default
 * @author Fran Iglesias
 */

interface Templating {
	public function loadTemplate($template);
}
?>

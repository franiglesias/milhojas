<?php

namespace Milhojas\Infrastructure\Templating;

/**
 * Interface for decoupling template systems
 *
 * @package default
 * @author Fran Iglesias
 */

interface Templating {
	public function loadTemplate($template);
}
?>
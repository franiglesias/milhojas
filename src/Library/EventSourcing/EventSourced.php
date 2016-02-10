<?php

namespace Milhojas\Library\EventSourcing;

/**
 * An entity that can be Event Sourced
 *
 * @package default
 * @author Francisco Iglesias Gómez
 */

interface EventSourced {
	public function getEvents();
	public function getEntityId();
}

?>
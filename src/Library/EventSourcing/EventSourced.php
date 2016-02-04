<?php

namespace Milhojas\Library\EventSourcing;

interface EventSourced {
	public function getEvents();
	public function getId();
}

?>
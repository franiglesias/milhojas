<?php

namespace Milhojas\Library\EventSourcing;

interface DomainEvent {
	public function getEntityId();
}

?>
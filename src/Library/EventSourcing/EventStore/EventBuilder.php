<?php

namespace Milhojas\Library\EventSourcing\EventStore;

use Milhojas\Library\EventSourcing\EventMessage;
use Milhojas\Library\EventSourcing\EventStore\Event;
/**
* Description
*/
class EventBuilder
{
	public function build(EventMessage $event)
	{
		$dto = new EventDTO();
		$dto->setId($event->getEnvelope()->getId());
		return $dto;
	}
}

?>
<?php

namespace Milhojas\Library\EventSourcing;

/**
* Description
*/
class EventMessage
{
	private $id;
	private $version;
	private $event;
	private $recordedOn;
	private $metadata;
	
	function __construct()
	{
		# code...
	}
}

?>
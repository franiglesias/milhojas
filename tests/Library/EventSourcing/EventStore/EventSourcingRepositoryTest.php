<?php

namespace Tests\Library\EventSourcing\EventStore;

use Milhojas\Library\EventSourcing\EventStore\EventSourcingRepository;
use Milhojas\Library\EventSourcing\EventStore\InMemoryEventStorage;

class EventSourcingRepositoryTest extends \PHPUnit_Framework_TestCase {
	
	public function test_it_creates_an_event_sourcing_repository()
	{
		$repo = new EventSourcingRepository(new InMemoryEventStorage(), 'Entity');
	}
}
?>
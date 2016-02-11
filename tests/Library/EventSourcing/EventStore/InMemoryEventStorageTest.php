<?php

namespace Tests\Milhojas\Library\EventSourcing\EventStore;

use Milhojas\Library\EventSourcing\EventStore\InMemoryEventStorage;
use Milhojas\Library\EventSourcing\EventStore\EntityData;
use Milhojas\Library\EventSourcing\EventStream;

class InMemoryEventStorageTest extends \PHPUnit_Framework_TestCase
{
	public function test_it_can_store_an_event_strem_for_an_entity()
	{
		$Storage = new InMemoryEventStorage();
		$Stream = new EventStream(array('event 1', 'event 2', 'event 3'));
		$expected = array('Entity' => array(1 => array('event 1', 'event 2', 'event 3')));
		$Storage->saveStream( new EntityData('Entity', '1'), $Stream);
		$this->assertAttributeEquals($expected, 'events', $Storage);
		
	}
	
	public function test_it_can_store_an_event_stream_for_different_entities()
	{
		$Stream = new EventStream(array('event 1', 'event 2', 'event 3'));
		$Stream2 = new EventStream(array('event 4', 'event 5'));
		$expected = array(
			'Entity' => array(1 => array('event 1', 'event 2', 'event 3')),
			'OtherEntity' => array(2 => array('event 4', 'event 5'))
		);
		
		$Storage = new InMemoryEventStorage();
		$Storage->saveStream( new EntityData('Entity', '1'), $Stream);
		$Storage->saveStream( new EntityData('OtherEntity', 2), $Stream2);
		
		$this->assertAttributeEquals($expected, 'events', $Storage);
	}
	
	public function test_it_can_load_an_event_stream_for_an_entity()
	{
		$Storage = new InMemoryEventStorage();
		$Stream = new EventStream(array('event 1', 'event 2', 'event 3'));
		$expected = array('Entity' => array(1 => array('event 1', 'event 2', 'event 3')));
		$Storage->saveStream( new EntityData('Entity', '1'), $Stream);
		$loadedStream = $Storage->loadStream(new EntityData('Entity', 1));
		$this->assertEquals($Stream, $loadedStream);
	}
	
	public function test_it_counts_events_for_an_entity()
	{
	
	}
}

?>
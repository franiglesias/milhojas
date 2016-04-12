<?php

namespace Milhojas\Infrastructure\Persistence\Storage\Drivers;


use Milhojas\Infrastructure\Persistence\Storage\Drivers\StorageDriver;

use Milhojas\Library\EventSourcing\DTO\EntityData;
use Milhojas\Library\EventSourcing\EventStream\EventStream;
use Milhojas\Library\EventSourcing\Exceptions as Exception;

/**
* A simple in memory event storage.
*/
class InMemoryEventStorageDriver implements StorageDriver
{
	/**
	 * Store the events
	 *
	 * @var array
	 * $events[$entity_type][$entity_id] = foreach eventStream
	 */
	private $events;
	
	function __construct()
	{
		$this->events = array();
	}
	public function load($id) 
	{
		
	}
	
	public function save($id, $object) 
	{
	}
	
	public function delete($id) 
	{
		
	}
	public function findAll() 
	{
		
	}
	public function countAll() 
	{
		
	}
	
	
	

	
}

?>
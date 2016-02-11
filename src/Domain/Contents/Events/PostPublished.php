<?php

namespace Milhojas\Domain\Contents\Events;

use Milhojas\Library\EventSourcing\DomainEvent;
/**
* A Post was published from a date
*/
class PostPublished implements DomainEvent
{
	private $id;
	private $publication;
	private $expiration;
	
	function __construct($id, \DateTimeImmutable $publication, \DateTimeImmutable $expiration = null)
	{
		$this->id = $id;
		$this->publication = $publication;
		$this->expiration = $expiration;
	}
	
	public function getEntityId()
	{
		return $this->id;
	}
	
	public function getPublication()
	{
		return $this->publication;
	}
	
	public function getExpiration()
	{
		return $this->expiration;
	}
}
?>
<?php

namespace Milhojas\Domain\Contents\Events;

use Milhojas\Library\EventSourcing\Domain\DomainEvent;
/**
* A Post was published from a date
*/
class PostWasPublished implements DomainEvent
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
	
	public function getId()
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
	
	public function getName()
	{
		return 'milhojas.post_was_published';
	}
}
?>
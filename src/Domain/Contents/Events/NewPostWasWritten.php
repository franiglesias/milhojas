<?php

namespace Milhojas\Domain\Contents\Events;
use Milhojas\Library\EventSourcing\Domain\DomainEvent;

/**
* A Post Was Written by first time
*/
class NewPostWasWritten implements DomainEvent
{
	private $id;
	private $title;
	private $body;
	private $author;
	
	function __construct($id, $title, $body, $author)
	{
		$this->id = $id;
		$this->title = $title;
		$this->body = $body;
		$this->author = $author;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getTitle()
	{
		return $this->title;
	}
	
	public function getBody()
	{
		return $this->body;
	}
	
	public function getAuthor()
	{
		return $this->author;
	}
	
	public function getName()
	{
		return 'milhojas.contents.new_post_was_written';
	}
}

?>
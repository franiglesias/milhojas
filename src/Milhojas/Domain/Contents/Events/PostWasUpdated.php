<?php

namespace Milhojas\Domain\Contents\Events;

use Milhojas\Messaging\EventBus\Event;
/**
* An existent post was updated
*/
class PostWasUpdated implements Event
{
	private $id;
	private $title;
	private $body;
	private $author;
	
	public function __construct($id, $title, $body, $author)
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
		return 'contents.post_was_updated';
	}
	
	public function __toString()
	{
		return sprintf('Post %s, with title %s by %s updated', $this->id, $this->title, $this->author);
	}
	
}

?>

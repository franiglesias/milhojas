<?php

namespace Milhojas\Domain\Contents\Events;
/**
* Description
*/
class NewPostWritten
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
	
	public function getAggregateId()
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
}

?>
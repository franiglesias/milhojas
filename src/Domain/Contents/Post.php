<?php

namespace Domain\Contents;

use Domain\Contents\PostId;
use Domain\Contents\PostStates as States;
/**
* Represents a Post (an article)
*/
class Post
{
	private $id;
	private $title;
	private $body;
	
	private $state;
	
	private $pubDate;
	
	function __construct(PostId $id, $title, $body)
	{
		$this->id = $id;
		$this->title = $title;
		$this->body = $body;
		$this->state = new States\DraftPostState();
	}
	
	public function publish(DateTimeInmutable $pubDate)
	{
		$this->state = $this->state->publish();
		$this->pubDate = $pubDate;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getState()
	{
		return $this->state;
	}
}

?>
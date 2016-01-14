<?php

namespace Domain\Contents;

use Domain\Contents\PostId;
/**
* Represents a Post (an article)
*/
class Post
{
	private $id;
	private $title;
	private $body;
	
	function __construct(PostId $id, $title, $body)
	{
		$this->id = $id;
		$this->title = $title;
		$this->body = $body;
	}
	
	public function getId()
	{
		return $this->id;
	}
}

?>
<?php

namespace Milhojas\Domain\Contents;

/**
* Represents the main content of an article, blog post, page
*/
class PostContent
{
	private $title;
	private $body;
	
	function __construct($title, $body)
	{
		$this->title = $title;
		$this->body = $body;
	}
	
	public function getTitle()
	{
		return $this->title;
	}
	
	public function getBody()
	{
		return $this->body;
	}
}

?>

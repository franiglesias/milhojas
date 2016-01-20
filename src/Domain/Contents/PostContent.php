<?php

namespace Domain\Contents;

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
}

?>
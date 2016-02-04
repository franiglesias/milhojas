<?php

namespace Tests\Library\Mapper\Utils;

/**
* Description
*/
class SimpleDTO
{
	private $id;
	private $title;
	private $content;
	
	function __construct()
	{
		# code...
	}
	
	public function setId($id)
	{
		$this->id = $id;
	}
	
	public function setTitle($title)
	{
		$this->title = $title;
	}
	
	public function setContent($content)
	{
		$this->content = $content;
	}
}

?>
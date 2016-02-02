<?php

namespace Tests\Library\Mapper\Utils;

/**
* Simple Model Class for Mapper Tests
*/
class SimpleModel
{
	private $id;
	private $title;
	private $content;
	
	function __construct($id, $title, $content)
	{
		$this->id = $id;
		$this->title = $title;
		$this->content = $content;
	}
}

?>
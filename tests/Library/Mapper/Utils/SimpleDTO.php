<?php


namespace Tests\Library\Mapper\Utils;
use Library\Mapper\Mappable;

/**
* Description
*/
class SimpleDTO implements Mappable
{
	private $id;
	private $title;
	private $content;
	
	function __construct()
	{
		# code...
	}
	
	public function fromMap($map)
	{
		$this->id = $map['simplemodel.id'];
		$this->title = $map['simplemodel.title'];
		$this->content = $map['simplemodel.content'];
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
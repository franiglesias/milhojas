<?php

namespace Milhojas\Application\Contents;

use Milhojas\Library\CommandBus\Command;

/**
* Description
*/
class UpdatePost implements Command
{
	private $id;
	private $title;
	private $body;
	
	public function __construct($id, $title, $body)
	{
		$this->id = $id;
		$this->title = $title;
		$this->body = $body;
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
}

?>
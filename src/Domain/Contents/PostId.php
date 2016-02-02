<?php

namespace Milhojas\Domain\Contents;
/**
* Value Object to represent PostID
*/
class PostId
{
	private $id;
	
	function __construct($id)
	{
		$this->id = $id;
	}
	
	public function getId()
	{
		return $this->id;
	}
}

?>
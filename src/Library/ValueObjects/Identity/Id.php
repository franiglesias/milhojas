<?php

namespace Milhojas\Library\ValueObjects\Identity;

use Rhumsaa\Uuid\Uuid;

class Id {
	
	private $id;
	
	public function __construct($id)
	{
		$this->id = $id;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	static public function create()
	{
		$uuid4 = Uuid::uuid4();
		return new static($uuid4->toString());
	}
	
	public function __toString()
	{
		return $this->id;
	}
}

?>
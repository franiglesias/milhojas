<?php

namespace Domain\Contents\Flags;

use Domain\Contents\Flags\Flag;

/**
* Description
*/
class FlagCollection
{
	private $data;
	
	function __construct(\SplObjectStorage $data)
	{
		$this->data = $data;
	}
	
	public function add(Flag $flag)
	{
		$this->data->attach($flag);
	}
	
	public function has(Flag $flag)
	{
		return $this->data->contains($flag);
	}
	
	public function remove(Flag $flag)
	{
		$this->data->detach($flag);
	}
	
	public function count()
	{
		return $this->data->count();
	}
}

?>
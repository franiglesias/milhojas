<?php

namespace Tests\Library\Mapper\Utils;

class ClassWithAllPropertyTypes
{
	private $id;
	private $empty;
	private $member;
	
	function __construct($id, EmptyClass $empty, ClassWithPlainProperties $member)
	{
		$this->id = $id;
		$this->empty = $empty;
		$this->member = $member;
	}
}

?>
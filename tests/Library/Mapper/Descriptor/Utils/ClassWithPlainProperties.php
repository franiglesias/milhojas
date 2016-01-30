<?php

namespace Tests\Library\Mapper\Descriptor\Utils;

class ClassWithPlainProperties {
	
	private $id;
	private $content;
	
	public function __construct($id, $content)
	{
		$this->id = $id;
		$this->content = $content;
	}
}

?>
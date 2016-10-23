<?php

namespace Milhojas\Infrastructure\Uploader\Namer;

/**
* Description
*/
class UniqueNamer
{
	private $generator;
	
	public function __construct($generator)
	{
		$this->generator = $generator;
	}
	
	public function make()
	{
		return $this->generator->get();
	}
}

?>

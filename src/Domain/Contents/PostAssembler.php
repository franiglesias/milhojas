<?php

namespace Domain\Contents;

use Domain\Contents\Post;
use Library\Mapper\SimpleMapper;

/**
* A simple Mapper to map Post to PostDTO
*/
class PostAssembler
{
	private $Mapper;
	
	public function __construct(SimpleMapper $Mapper)
	{
		$this->Mapper = $Mapper;
	}
	public function map(Post $Post, \Library\Mapper\PopulatedFromMapper $dto)
	{
		return $this->Mapper->map($Post, $dto);
	}
}

?>
<?php

namespace Infrastructure\Persistence\Contents;

use Domain\Contents\Post;
use Library\Mapper\SimpleMapper;
/**
* Description
*/
class PostMapper
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
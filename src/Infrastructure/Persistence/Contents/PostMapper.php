<?php

namespace Infrastructure\Persistence\Contents;

use Domain\Contents\PostMapperInterface;
use Domain\Contents\Post;
use Library\Mapper\SimpleMapper;
/**
* Description
*/
class PostMapper implements PostMapperInterface
{
	private $Mapper;
	
	public function __construct(SimpleMapper $Mapper)
	{
		$this->Mapper = $Mapper;
	}
	public function map(Post $Post, \Library\Mapper\Mappable $dto)
	{
		return $this->Mapper->map($Post, $dto);
	}
}

?>
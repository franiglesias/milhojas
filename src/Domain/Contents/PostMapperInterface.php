<?php

namespace Domain\Contents;

interface PostMapperInterface {
	public function map(Post $Post, \Library\Mapper\Mappable $dto);
}

?>
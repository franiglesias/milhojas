<?php

namespace Milhojas\Domain\Contents;

use Milhojas\Library\Mapper\DTOAssembler;
use Milhojas\Domain\Contents\DTO\PostDTO;

/**
* Description
*/
class PostDTOAssembler implements DTOAssembler
{
	public function assemble($map)
	{
		$dto = new PostDTO();
		$dto->setId($map['post.id.id']);
		$dto->getContent()->setTitle($map['post.content.title']);
		$dto->getContent()->setBody($map['post.content.body']);
		$dto->setState($map['post.state']);
		$dto->setPubDate($map['post.publication.start.date']);
		return $dto;
	}
}

?>
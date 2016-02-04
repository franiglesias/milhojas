<?php

namespace Milhojas\Domain\Contents;

use Milhojas\Domain\Contents\Post;
use Milhojas\Domain\Contents\DTO\PostDTO;
use Milhojas\Library\Mapper\Mapper;
use Milhojas\Library\Mapper\Assembler;

/**
* A simple Mapper to map Post to PostDTO
*/
class PostAssembler implements Assembler
{
	
	public function __construct()
	{
	}
	
	public function assemble($dto)
	{
		$Post = Post::write(
			new PostId($dto->getId()), 
			new PostContent(
				$dto->getContent()->getTitle(), 
				$dto->getContent()->getBody()
			)
		);
		$this->buildState($Post, $dto);
		return $Post;
	}
	
	private function buildState($Post, $dto)
	{
		switch ($dto->getState()) {
			case 'PublishedPostState':
				$expiration = null;
				if ($dto->getExpiration()) {
					$expiration = new \DateTimeImmutable($dto->getExpiration());
				}
				$dateRange = new \Milhojas\Library\ValueObjects\Dates\DateRange(
					new \DateTimeImmutable($dto->getPubDate()),
					$expiration
				);
				$Post->publish($dateRange);
				break;
			case 'RetiredPostState':
				$Post->retire();
				break;
			default:
				
			break;
		}
	}
}

?>
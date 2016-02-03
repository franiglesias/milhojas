<?php

namespace Milhojas\Domain\Contents;

use Milhojas\Domain\Contents\Post;
use Milhojas\Library\Mapper\Mapper;

/**
* A simple Mapper to map Post to PostDTO
*/
class PostAssembler
{
	private $Mapper;
	
	public function __construct(Mapper $Mapper)
	{
		$this->Mapper = $Mapper;
	}
	public function map(Post $Post, \Milhojas\Library\Mapper\PopulatedFromMapper $dto)
	{
		$map = $this->Mapper->map($Post);
		$dto->fromMap($map);
		return $dto;
	}
	
	public function build(\Milhojas\Library\Mapper\PopulatedFromMapper $dto)
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
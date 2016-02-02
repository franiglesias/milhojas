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
	
	public function build(\Library\Mapper\PopulatedFromMapper $dto)
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
				$dateRange = new \Library\ValueObjects\Dates\DateRange(
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
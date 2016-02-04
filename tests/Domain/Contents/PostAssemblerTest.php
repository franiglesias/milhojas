<?php

namespace Tests\Domain\Contents;

use Milhojas\Domain\Contents\PostAssembler;

use Milhojas\Library\Mapper\ObjectMapper;

use Milhojas\Domain\Contents\Post;
use Milhojas\Domain\Contents\PostId;
use Milhojas\Domain\Contents\PostContent;
use Milhojas\Domain\Contents\DTO\PostDTO;
use Milhojas\Domain\Contents\DTO\PostContentDTO;

/**
* Description
*/
class PostAssemblerTest extends \PHPUnit_Framework_Testcase
{
	
	private function getPost()
	{
		$Post = Post::write(new PostId(1), new PostContent('Title', 'Body'));
		$Post->publish(new \Milhojas\Library\ValueObjects\Dates\DateRange(new \DateTimeImmutable('2016-01-01')));
		return $Post;
	}
	
	private function getPostDTO()
	{
		$dto = new PostDTO();
		$dto->setId(1);
		$dto->getContent()->setTitle('Title');
		$dto->getContent()->setBody('Body');
		$dto->setPubDate('2016-01-01');
		$dto->setExpiration(null);
		$dto->setState('PublishedPostState');
		return $dto;
	}
		
	public function test_it_can_build_a_post_from_dto()
	{
		// $Expected = $this->getPost();
		// $dto = $this->getPostDTO();
		// $Assembler = new PostAssembler();
		// $Post = $Assembler->assemble($dto);
		// $this->assertEquals($Expected, $Post);
		
	}
}
?>
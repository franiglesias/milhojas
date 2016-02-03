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
	private function getMapper()
	{
		return $this->getMockBuilder('\Milhojas\Library\Mapper\ObjectMapper')
			->disableOriginalConstructor()
				->getMock();
	}
	
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
	
	public function test_it_maps_a_Post_object()
	{
		$Post = $this->getPost();
		$PostDTO = $this->getPostDTO();
		
		$map = array(
			'post.id.id' => 1,
			'post.content.title' => 'Title',
			'post.content.body' => 'Body',
			'post.publication.start' => '2016-01-01',
			'post.state' => 'PublishedPostState'
		);

		
		$Mapper = $this->getMapper();
		$Mapper->expects($this->once())
			->method('map')
				->with($this->equalTo($Post))
				->will($this->returnValue($map));
		
		$PostAssembler = new PostAssembler($Mapper);
		$dto = $PostAssembler->map($Post, $PostDTO);
		$this->assertEquals($dto, $PostDTO);
	}
	
	public function test_it_can_build_a_post_from_dto()
	{
		$Expected = $this->getPost();
		$dto = $this->getPostDTO();
		$Mapper = $this->getMapper();
		$Assembler = new PostAssembler($Mapper);
		$Post = $Assembler->build($dto);
		$this->assertEquals($Expected, $Post);
		
	}
}
?>
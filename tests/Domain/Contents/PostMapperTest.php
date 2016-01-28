<?php

namespace Tests\Domain\Contents;

use Domain\Contents\Post;
use Domain\Contents\PostId;
use Domain\Contents\PostContent;

use Domain\Contents\DTO\PostDTO;
use Domain\Contents\DTO\PostContentDTO;


use Library\Mapper\Descriptor\ObjectDescriptor;
use Library\Mapper\Descriptor\PropertyDescriptor;

/**
* Description
*/
class PostMapper
{
	private $Post;
	
	function __construct(\Domain\Contents\Post $Post)
	{
		$this->Post = $Post;
	}
	
	public function toDto($dto)
	{
		$mapper = new PostDTOMapper($this, $dto);
		return $mapper->map();
	}
	
	public function getDescription()
	{
		$descriptor = new ObjectDescriptor($this->Post);
		return $descriptor->describe();
	}
}



/**
* Description
*/
// class PostMapperTest extends \PHPUNit_Framework_Testcase
// {
// 	public function test_nothing()
// 	{
//
// 	}
// 	public function dont_test_post_mapper_accepts_Post_Entity()
// 	{
// 		$Post = Post::write(new PostId(1), new PostContent('Title', 'Body'));
// 		$mapper = new PostMapper($Post);
// 		$result = $mapper->toDto(new PostDTO());
// 	}
//
// 	public function dont_test_post_mapper_generates_post_description()
// 	{
// 		$Post = Post::write(new PostId(1), new PostContent('Title', 'Body'));
// 		$Post->publish(new \Library\ValueObjects\Dates\DateRange(new \DateTimeImmutable()));
// 		$description = array(
// 			'post.id.id' => 1,
// 			'post.content.title' => 'Title',
// 			'post.content.body' => 'Body',
// 			'post.publication.start' => date('Y/m/d'),
// 			'post.publication.end' => null
// 		);
// 		$mapper = new PostMapper($Post);
// 		$this->assertEquals($description, $mapper->getDescription());
// 	}
// }

?>
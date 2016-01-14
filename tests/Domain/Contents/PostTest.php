<?php

namespace Tests\Domain\Contents;

use Domain\Contents\Post;
use Domain\Contents\PostId;

/**
* Description
*/
class PostTest extends \PHPUnit_Framework_Testcase
{
	
	function test_Post_must_have_id_title_and_body()
	{
		$Post = new Post(new PostId(1), 'Title', 'Body');
		$this->assertInstanceOf('Domain\Contents\Post', $Post);
		$this->assertEquals(new PostId(1), $Post->getId());
		$this->assertInstanceOf('Domain\Contents\PostStates\DraftPostState', $Post->getState());
	}
	
	public function test_Post_can_be_published()
	{
		$Post = new Post(new PostId(1), 'Title', 'Body');
		$Post->publish(new \DateTimeInmutable());
		$this->assertInstanceOf('Domain\Contents\PostStates\PublishedPostState', $Post->getState());
	}
	
	
}
?>
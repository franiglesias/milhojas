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
	}
	
}
?>
<?php

namespace Tests\Domain\Contents;

use \Milhojas\Domain\Contents\PostContent;

/**
* Description
*/
class PostContentTest extends \PHPUnit_Framework_TestCase
{
	public function test_it_creates_post_contents()
	{
		$Article = new PostContent('A title', 'A body');
		$this->assertInstanceOf('\Milhojas\Domain\Contents\PostContent', $Article);
		$this->assertAttributeEquals('A title', 'title', $Article);
		$this->assertAttributeEquals('A body', 'body', $Article);
	}
}
?>
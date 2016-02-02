<?php

namespace Tests\Domain\Contents;

use \Milhojas\Domain\Contents\Post;
use \Milhojas\Domain\Contents\PostId;
use \Milhojas\Domain\Contents\PostContent;
use \Milhojas\Domain\Contents\Flags as Flag;

/**
* Description
*/
class PostTest extends \PHPUnit_Framework_Testcase
{
	
	public function test_can_write_a_new_post()
	{
		$Post = Post::write(new PostId(1), new PostContent('Title', 'Body'));
		$this->assertInstanceOf('\Milhojas\Domain\Contents\Post', $Post);
	}
	
	public function test_new_Post_is_valid()
	{
		$Post = Post::write(new PostId(1), new PostContent('Title', 'Body'));
		$this->assertEquals(new PostId(1), $Post->getId());
		$this->assertInstanceOf('\Milhojas\Domain\Contents\PostStates\DraftPostState', $Post->getState());
		$this->assertAttributeEquals(new PostContent('Title', 'Body'), 'content', $Post);
	}
	
	public function test_Post_can_be_published()
	{
		$Post = Post::write(new PostId(1), new PostContent('Title', 'Body'));
		$Post->publish(new \Milhojas\Library\ValueObjects\Dates\DateRange(new \DateTimeImmutable()));
		$this->assertInstanceOf('\Milhojas\Domain\Contents\PostStates\PublishedPostState', $Post->getState());
	}
	
	public function test_Post_can_be_retired()
	{
		$Post = Post::write(new PostId(1), new PostContent('Title', 'Body'));
		$Post->publish(new \Milhojas\Library\ValueObjects\Dates\DateRange(new \DateTimeImmutable()));
		$Post->retire();
		$this->assertInstanceOf('\Milhojas\Domain\Contents\PostStates\RetiredPostState', $Post->getState());
	}

	/**
	 * @expectedException UnderflowException
	 *
	 */
	public function test_Post_in_Draft_can_not_be_retired()
	{
		$Post = Post::write(new PostId(1), new PostContent('Title', 'Body'));
		$Post->retire();
	}
	
	// public function test_Post_can_be_flagged_as_featured()
	// {
	// 	$Post = Post::write(new PostId(1), new PostContent('Title', 'Body'));
	// 	$Post->addFlag(Flag\FeaturedFlag::get());
	// 	$this->assertTrue($Post->hasFlag(Flag\FeaturedFlag::get()));
	// }
	//
	// public function test_Post_can_be_flagged_as_sticky()
	// {
	// 	$Post = Post::write(new PostId(1), new PostContent('Title', 'Body'));
	// 	$Post->addFlag(Flag\FeaturedFlag::get());
	// 	$this->assertTrue($Post->hasFlag(Flag\FeaturedFlag::get()));
	// }
	//
	// public function test_Post_can_be_flagged_with_more_than_one_flag()
	// {
	// 	$Post = Post::write(new PostId(1), new PostContent('Title', 'Body'));
	// 	$Post->addFlag(Flag\FeaturedFlag::get());
	// 	$Post->addFlag(Flag\StickyFlag::get());
	// 	$this->assertTrue($Post->hasFlag(Flag\StickyFlag::get()));
	// 	$this->assertTrue($Post->hasFlag(Flag\FeaturedFlag::get()));
	// }
	//
	// public function test_Post_can_be_flagged_and_remove_flag()
	// {
	// 	$Post = Post::write(new PostId(1), new PostContent('Title', 'Body'));
	// 	$Post->addFlag(Flag\FeaturedFlag::get());
	// 	$Post->addFlag(Flag\StickyFlag::get());
	// 	$Post->removeFlag(Flag\FeaturedFlag::get());
	// 	$this->assertTrue($Post->hasFlag(Flag\StickyFlag::get()));
	// 	$this->assertFalse($Post->hasFlag(Flag\FeaturedFlag::get()));
	// }
	
	public function test_Post_is_published_on_date()
	{
		$Post = Post::write(new PostId(1), new PostContent('Title', 'Body'));
		$Post->publish(new \Milhojas\Library\ValueObjects\Dates\DateRange(new \DateTimeImmutable('-10 day')));
		$this->assertTrue($Post->isPublished(new \DateTimeImmutable()));
		$this->assertFalse($Post->isPublished(new \DateTimeImmutable('-20 day')));
		$this->assertTrue($Post->isPublished());
	}
}
?>
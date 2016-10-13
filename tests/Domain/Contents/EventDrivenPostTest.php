<?php

namespace Tests\Domain\Contents;

use Milhojas\Domain\Contents\Post;
use Milhojas\Domain\Contents\PostId;
use Milhojas\Domain\Contents\PostContent;
use Milhojas\Domain\Contents\Flags as Flag;

use Milhojas\Domain\Contents\Events\NewPostWasWritten;
use Milhojas\Domain\Contents\Events\PostWasUpdated;
use Milhojas\Domain\Contents\Events\PostWasPublished;
use Milhojas\Domain\Contents\Events\PostWasRetired;

class EventDrivenPostTest extends \PHPUnit_Framework_Testcase {
	
	
	public function test_it_handles_post_updated()
	{
		$Post = Post::write(new PostId(1), new PostContent('Title', 'Body'), 'Author');
		$Event = new PostWasUpdated(1, 'New Title', 'New Body', 'New author');
		$Post->apply($Event);
		$this->assertEquals(new PostId(1), $Post->getId());
		$this->assertInstanceOf('\Milhojas\Domain\Contents\PostStates\DraftPostState', $Post->getState());
		$this->assertAttributeEquals(new PostContent('New Title', 'New Body'), 'content', $Post);
		$this->assertAttributeInstanceOf('\Milhojas\Library\ValueObjects\Dates\DateRange', 'publication', $Post);
	}

	public function test_it_handles_post_published()
	{
		$Post = Post::write(new PostId(1), new PostContent('Title', 'Body'), 'Author');
		$Event = new PostWasPublished(1, new \DateTimeImmutable('2016-01-01'));
		$Post->apply($Event);
		$this->assertEquals(new PostId(1), $Post->getId());
		$this->assertInstanceOf('\Milhojas\Domain\Contents\PostStates\PublishedPostState', $Post->getState());
	}
	
	public function test_it_handles_post_retired()
	{
		$Post = Post::write(new PostId(1), new PostContent('Title', 'Body'), 'Author');
		$Event = new PostWasRetired(1);
		$Post->apply($Event);
		$this->assertEquals(new PostId(1), $Post->getId());
		$this->assertInstanceOf('\Milhojas\Domain\Contents\PostStates\RetiredPostState', $Post->getState());
	}

}

?>

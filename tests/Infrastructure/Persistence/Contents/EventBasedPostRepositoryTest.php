<?php

namespace Tests\Infrastructure\Persistence\Contents;

use Milhojas\Infrastructure\Persistence\Contents\EventBasedPostRepository;

use Milhojas\Domain\Contents\Post;
use Milhojas\Domain\Contents\PostId;
use Milhojas\Domain\Contents\PostContent;
use Milhojas\Library\ValueObjects\Dates\DateRange;

use Milhojas\Infrastructure\Persistence\Storage\EventBasedStorage;
use Milhojas\Infrastructure\Persistence\Storage\Drivers\InMemoryStorageDriver;


use Milhojas\Library\EventSourcing\DTO\EntityDTO;
use Milhojas\Library\EventSourcing\EventStream\EventMessage;
use Milhojas\Library\EventSourcing\EventStream\EventStream;

class EventBasedPostRepositoryTest extends \PHPUnit_Framework_Testcase
{
	public function test_it_can_save_a_post()
	{
		$this->start_a_repository();
		
		$Post = $this->getRealPost();
		$this->Repository->save($Post);
	}
	
	public function test_it_can_load_a_saved_post()
	{
		$this->start_a_repository();
		
		$Post = $this->getRealPost();
		$this->Repository->save($Post);

		$expected = $this->getRealPost();
		$expected->clearEvents();
		
		$Post = $this->Repository->get(new PostId(1));
		

		$this->assertInstanceOf('Milhojas\Domain\Contents\Post', $Post);
		$this->assertEquals($expected, $Post);
	}
	
	/**
	 * @expectedException Milhojas\Domain\Contents\Exceptions\PostWasNotFound
	 */
	public function test_exception_if_Post_does_not_exist()
	{
		$this->start_a_repository();
		$Post = $this->Repository->get(new PostId(1));
	}
	
	private function start_a_repository()
	{
		$this->Repository = new EventBasedPostRepository(
			new EventBasedStorage(
				new InMemoryStorageDriver(), 
				'Milhojas\Domain\Contents\Post'
			)
		);
	}
	
	public function repository_should_have_a_post()
	{
		$this->assertEquals(1, $this->Repository->count(), 'Repository has no post');
	}
	
	private function load_a_post_from_the_repository()
	{
		$Post = $this->Repository->get(new PostId(1));
		$this->assertInstanceOf('Milhojas\Domain\Contents\Post', $Post);
	}
	
		
	public function getRealPost()
	{
		$Post = Post::write(new PostId(1), new PostContent('Title', 'Body of the post'), 'author');
		$Post->update(new PostContent('Updated title', 'Updated body'), 'new author');
		$Post->publish(DateRange::open(new \DateTimeImmutable()));
		return $Post;
	}
	
	
}
?>
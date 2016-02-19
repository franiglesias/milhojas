<?php

namespace Tests\Infrastructure\Persistence\Contents;

use Milhojas\Infrastructure\Persistence\Contents\EventSourcedPostRepository;

use Milhojas\Domain\Contents\Post;
use Milhojas\Domain\Contents\PostId;
use Milhojas\Domain\Contents\PostContent;
use Milhojas\Library\ValueObjects\Dates\DateRange;

use Milhojas\Library\EventSourcing\EventStore\InMemoryEventStorage;
use Milhojas\Library\EventSourcing\DTO\EntityData;
use Milhojas\Library\EventSourcing\EventMessage;
use Milhojas\Library\EventSourcing\EventStream\EventStream;

class EventSourcedPostRepositoryTest extends \PHPUnit_Framework_Testcase
{
	
	
	
	public function test_it_can_save_a_post()
	{
		$this->start_a_repository();
		$this->save_a_post_in_the_repository();
		$this->repository_should_have_a_post();
	}
	
	public function test_it_can_load_a_saved_post()
	{
		$this->start_a_repository();
		$this->save_a_post_in_the_repository();
		$this->load_a_post_from_the_repository();
		$this->loaded_post_should_be_the_same_as_expected();
	}
	
	private function start_a_repository()
	{
		$this->Repository = new EventSourcedPostRepository(new InMemoryEventStorage());
	}
	
	private function save_a_post_in_the_repository()
	{
		$Post = $this->getRealPost();
		$this->Repository->save($Post);
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
	
	private function loaded_post_should_be_the_same_as_expected()
	{
		# code...
	}
	
	private function getPost()
	{
		$Post = $this
			->getMockBuilder('Milhojas\Domain\Contents\Post')
			->setMockClassName('Post')
			->disableOriginalConstructor()
			->getMock();
		$Stream = $this->prepare_stream_for_entity($this->getEntity(1, 3), 3);
		$Post->expects($this->once())
			->method('getEvents')
			->will($this->returnValue($Stream));
		return $Post;
	}
	
	public function getRealPost()
	{
		$Post = Post::write(new PostId(1), new PostContent('Title', 'Body of the post'), 'author');
		$Post->update(new PostContent('Updated title', 'Updated body'), 'new author');
		$Post->publish(DateRange::open(new \DateTimeImmutable()));
		return $Post;
	}
	
	private function getEvent()
	{
		return $this->getMockBuilder('Milhojas\Domain\Contents\Events\PostWasUpdated')
			->setMockClassName('PostWasUpdated')
			->disableOriginalConstructor()
			->getMock();
	}

	private function getEntity($id = 1, $version = -1)
	{
		return new EntityData('Post', $id, $version);
	}
	
	private function prepare_stream_for_entity($entity, $eventCount)
	{
		$messages = array();
		$event = $this->getEvent();
		for ($i=0; $i < $eventCount; $i++) { 
			$messages[] = EventMessage::record($event, $entity);
		}
		return new EventStream($messages);
	}
	
	
}
?>
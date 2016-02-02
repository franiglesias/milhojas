<?php

namespace Tests\Infrastructure\Persistence\Contents;

use Milhojas\Infrastructure\Persistence\Contents\InMemoryPostRepository;
use Milhojas\Infrastructure\Persistence\Common\InMemoryStorage;

use Milhojas\Domain\Contents\Specifications\CurrentlyPublishedPostSpecification;

/**
* Description
*/
class InMemoryPostRespositoryTest extends \PHPUnit_Framework_Testcase
{
	public function test_Can_Store_A_Post()
	{
		$Post = \Milhojas\Domain\Contents\Post::write(new \Milhojas\Domain\Contents\PostId(1), new \Milhojas\Domain\Contents\PostContent('Title', 'Body'));
		$Repository = new InMemoryPostRepository(new InMemoryStorage());
		$Repository->save($Post);
		$this->assertEquals(1, $Repository->countAll());
	}
	
	public function test_Can_Retrieve_A_Post_By_Id()
	{
		$Post = \Milhojas\Domain\Contents\Post::write(new \Milhojas\Domain\Contents\PostId(1), new \Milhojas\Domain\Contents\PostContent('Title', 'Body'));
		$Repository = new InMemoryPostRepository(new InMemoryStorage());
		$Repository->save($Post);
		$Stored = $Repository->get(new \Milhojas\Domain\Contents\PostId(1));
		$this->assertEquals($Post, $Stored);
	}
	
	/**
	 * @expectedException Milhojas\Domain\Contents\Exceptions\PostWasNotFound
	 *
	 */
	public function test_if_id_does_not_exists_throws_exception()
	{
		$Post = \Milhojas\Domain\Contents\Post::write(new \Milhojas\Domain\Contents\PostId(1), new \Milhojas\Domain\Contents\PostContent('Title', 'Body'));
		$Repository = new InMemoryPostRepository(new InMemoryStorage());
		$Repository->save($Post);
		$Stored = $Repository->get(new \Milhojas\Domain\Contents\PostId(2));
	}
	
	public function test_use_a_specification_to_return_post()
	{
		$Repository = new InMemoryPostRepository(new InMemoryStorage());

		$Post = \Milhojas\Domain\Contents\Post::write(new \Milhojas\Domain\Contents\PostId(1), new \Milhojas\Domain\Contents\PostContent('Title', 'Body'));
		$Post->publish(new \Milhojas\Library\ValueObjects\Dates\DateRange(new \DateTimeImmutable()));
		$Repository->save($Post);
		
		$Post2 = \Milhojas\Domain\Contents\Post::write(new \Milhojas\Domain\Contents\PostId(2), new \Milhojas\Domain\Contents\PostContent('Title 2', 'Body 2'));
		$Repository->save($Post2);
		
		$Response = $Repository->findSatisfying(new CurrentlyPublishedPostSpecification());
		$this->assertCount(1, $Response);
		$this->assertEquals($Post, array_shift($Response));
	}
	
	public function test_use_a_specification_return_empty_array_if_nothing_found()
	{
		$Repository = new InMemoryPostRepository(new InMemoryStorage());

		$Post = \Milhojas\Domain\Contents\Post::write(new \Milhojas\Domain\Contents\PostId(1), new \Milhojas\Domain\Contents\PostContent('Title', 'Body'));
		$Repository->save($Post);
		
		$Post2 = \Milhojas\Domain\Contents\Post::write(new \Milhojas\Domain\Contents\PostId(2), new \Milhojas\Domain\Contents\PostContent('Title 2', 'Body 2'));
		$Repository->save($Post2);
		
		$Post3 = \Milhojas\Domain\Contents\Post::write(new \Milhojas\Domain\Contents\PostId(3), new \Milhojas\Domain\Contents\PostContent('Title 3', 'Body 3'));
		$Repository->save($Post3);
		
		$Response = $Repository->findSatisfying(new CurrentlyPublishedPostSpecification());
		$this->assertCount(0, $Response);
	}
	
}

?>
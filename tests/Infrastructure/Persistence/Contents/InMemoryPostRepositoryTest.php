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
	
	private function getPost($id = 1)
	{
		$Post = \Milhojas\Domain\Contents\Post::write(new \Milhojas\Domain\Contents\PostId($id), new \Milhojas\Domain\Contents\PostContent('Title', 'Body'));
		return $Post;
	}
	
	public function test_Can_Store_A_Post()
	{
		$Post = $this->getPost();
		$Repository = new InMemoryPostRepository(new InMemoryStorage());
		$Repository->save($Post);
		$this->assertEquals(1, $Repository->countAll());
	}
	
	public function test_Can_Retrieve_A_Post_By_Id()
	{
		$Post = $this->getPost();
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
		$Post = $this->getPost();
		$Repository = new InMemoryPostRepository(new InMemoryStorage());
		$Repository->save($Post);
		$Stored = $Repository->get(new \Milhojas\Domain\Contents\PostId(2));
	}
	
	public function test_use_a_specification_to_return_post()
	{
		$Repository = new InMemoryPostRepository(new InMemoryStorage());

		$Post = $this->getPost();
		$Post->publish(new \Milhojas\Library\ValueObjects\Dates\DateRange(new \DateTimeImmutable()));
		$Repository->save($Post);
		
		$Post2 = $this->getPost(2);
		$Repository->save($Post2);
		
		$Response = $Repository->findSatisfying(new CurrentlyPublishedPostSpecification());
		$this->assertCount(1, $Response);
		$this->assertEquals($Post, array_shift($Response));
	}
	
	public function test_use_a_specification_return_empty_array_if_nothing_found()
	{
		$Repository = new InMemoryPostRepository(new InMemoryStorage());

		$Post = $this->getPost();
		
		$Repository->save($Post);
		
		$Post2 = $this->getPost(2);
		$Repository->save($Post2);
		
		$Post3 = $this->getPost(3);
		$Repository->save($Post3);
		
		$Response = $Repository->findSatisfying(new CurrentlyPublishedPostSpecification());
		$this->assertCount(0, $Response);
	}
	
}

?>
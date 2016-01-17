<?php

namespace Tests\Infrastructure\Persistence\Contents;

use Infrastructure\Persistence\Contents\InMemoryPostRepository;

/**
* Description
*/
class InMemoryPostRespositoryTest extends \PHPUnit_Framework_Testcase
{
	public function test_Can_Store_A_Post()
	{
		$Post = \Domain\Contents\Post::write(new \Domain\Contents\PostId(1), 'Title', 'Body');
		$Repository = new InMemoryPostRepository();
		$Repository->save($Post);
		$this->assertEquals(1, $Repository->countAll());
	}
	
	public function test_Can_Retrieve_A_Post_By_Id()
	{
		$Post = \Domain\Contents\Post::write(new \Domain\Contents\PostId(1), 'Title', 'Body');
		$Repository = new InMemoryPostRepository();
		$Repository->save($Post);
		$Stored = $Repository->get(new \Domain\Contents\PostId(1));
		$this->assertEquals($Post, $Stored);
	}
	
	/**
	 * @expectedException Domain\Contents\Exceptions\NotFoundPostException
	 *
	 */
	public function test_if_id_does_not_exists_throws_exception()
	{
		$Post = \Domain\Contents\Post::write(new \Domain\Contents\PostId(1), 'Title', 'Body');
		$Repository = new InMemoryPostRepository();
		$Repository->save($Post);
		$Stored = $Repository->get(new \Domain\Contents\PostId(2));
	}
	
	
}

?>
<?php

namespace Tests\Application\Contents\Projectors;

use Milhojas\Application\Contents\Projectors\PostListProjector;

use Tests\Infrastructure\Persistence\Shared\DoctrineTestCase;
use Milhojas\Domain\Contents\Events\NewPostWasWritten;
use Milhojas\Domain\Contents\Events\PostWasUpdated;
/**
* Description
*/
class PostListProjectorTest extends DoctrineTestCase
{
	
    /**
     * Set up repository test
     */
    public function setUp()
    {
        // $this->loadFixturesFromDirectory(__DIR__ . '/Fixtures');
		// $this->em->createQuery('delete from Contents:PostList')->execute();
    }
	
	public function test_it_add_a_new_post_to_empty_projection()
	{
		$projector = new PostListProjector($this->em);
		$projector->handle( new NewPostWasWritten(10, 'The title', 'The content', 'Author') );
		$result = $this->em->getRepository('Contents:PostList')->findAll();
		$this->assertEquals(1, count($result));
	}

	public function test_it_can_add_a_new_post_to_projection()
	{
		$projector = new PostListProjector($this->em);
		$projector->handle( new NewPostWasWritten(10, 'The title', 'The content', 'Author') );
		$projector->handle( new NewPostWasWritten(12, 'Title 12', 'Content for 12', 'Author') );
		$result = $this->em->getRepository('Contents:PostList')->findAll();
		$this->assertEquals(2, count($result));
	}
	
	public function test_it_can_update_an_existing_projection()
	{
		$projector = new PostListProjector($this->em);
		$projector->handle( new NewPostWasWritten(10, 'The title', 'The content', 'Author') );
		$projector->handle( new NewPostWasWritten(12, 'Title 12', 'Content for 12', 'Author') );
		$projector->handle( new PostWasUpdated(12, 'New title for 12', 'New content for 12', 'New author') );
		$result = $this->em->getRepository('Contents:PostList')->findAll();
		$this->assertEquals(2, count($result));
	}

}

?>

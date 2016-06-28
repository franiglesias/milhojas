<?php

namespace Tests\Application\Contents\Projectors;

use Milhojas\Application\Contents\Projectors\PostListProjector;

use Tests\Infrastructure\Persistence\Common\DoctrineTestCase;
use Milhojas\Domain\Contents\Events\NewPostWasWritten;

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
        $this->loadFixturesFromDirectory(__DIR__ . '/Fixtures');
    }
	
	public function test_it_can_update_a_post_based_in_event_data()
	{
		$projector = new PostListProjector($this->em);
		$event = new NewPostWasWritten(10, 'The title', 'The content', 'Author');
		$projector->handle($event);
		
		$result = $this->em->getRepository('Contents:PostList')->findAll();
		$this->assertEquals(3, count($result));
		
	}
}

?>
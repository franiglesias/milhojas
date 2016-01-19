<?php

namespace Test\Domain\Contents\Specifications;

use Domain\Contents\Specifications\PostSpecificationInterface;
use Domain\Contents\Specifications\CurrentlyPublishedPostSpecification;

class CurrentlyPublishedPostSpecificationTest extends \PHPUnit_Framework_Testcase {
	
	public function test_Created_Post_does_not_satisfy_CurrentlyPublishedPostSpecification()
	{
		$spec = new CurrentlyPublishedPostSpecification();
		$Post = \Domain\Contents\Post::write(new \Domain\Contents\PostId(1), 'Title', 'Body');
		$this->assertFalse($spec->isSatisfiedBy($Post));
	}
	
	public function test_Published_Post_satisfies_CurrentlyPostSpecification()
	{
		$spec = new CurrentlyPublishedPostSpecification();
		$Post = \Domain\Contents\Post::write(new \Domain\Contents\PostId(1), 'Title', 'Body');
		$Post->publish(new \Library\ValueObjects\Dates\PublicationDateRange(new \DateTimeImmutable()));
		$this->assertTrue($spec->isSatisfiedBy($Post));
	}
	
}
?>
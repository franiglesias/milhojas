<?php

namespace Test\Domain\Contents\Specifications;

use Milhojas\Domain\Contents\Specifications\PostSpecification;
use Milhojas\Domain\Contents\Specifications\CurrentlyPublishedPostSpecification;

class CurrentlyPublishedPostSpecificationTest extends \PHPUnit_Framework_Testcase {
	
	public function test_Created_Post_does_not_satisfy_CurrentlyPublishedPostSpecification()
	{
		$spec = new CurrentlyPublishedPostSpecification();
		$Post = \Milhojas\Domain\Contents\Post::write(new \Milhojas\Domain\Contents\PostId(1), new \Milhojas\Domain\Contents\PostContent('Title', 'Body'));
		$this->assertFalse($spec->isSatisfiedBy($Post));
	}
	
	public function test_Published_Post_satisfies_CurrentlyPostSpecification()
	{
		$spec = new CurrentlyPublishedPostSpecification();
		$Post =\Milhojas\Domain\Contents\Post::write(new \Milhojas\Domain\Contents\PostId(1), new \Milhojas\Domain\Contents\PostContent('Title', 'Body'));
		$Post->publish(new \Milhojas\Library\ValueObjects\Dates\DateRange(new \DateTimeImmutable()));
		$this->assertTrue($spec->isSatisfiedBy($Post));
	}
	
}
?>
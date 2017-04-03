<?php

namespace Milhojas\Domain\Contents\Specifications;
use Milhojas\Domain\Contents\Post;


/**
* Description
*/
class CurrentlyPublishedPostSpecification
{
    public function isSatisfiedBy(Post $Post)
	{
		return $Post->isPublished(new \DateTimeImmutable());
	}
}

?>

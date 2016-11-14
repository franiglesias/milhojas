<?php

namespace Milhojas\Domain\Contents\PostStates;
use Milhojas\Domain\Contents\PostStates\AbstractPostState;

/**
* Describes a Post not published
*/
class DraftPostState extends AbstractPostState
{
	public function publish()
	{
		return new \Milhojas\Domain\Contents\PostStates\PublishedPostState();
	}

}
?>

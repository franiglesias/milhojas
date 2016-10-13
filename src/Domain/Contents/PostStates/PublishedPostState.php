<?php

namespace Milhojas\Domain\Contents\PostStates;
use Milhojas\Domain\Contents\PostStates\AbstractPostState;

/**
* Describes a Post not published
*/
class PublishedPostState extends AbstractPostState
{
	public function retire()
	{
		return new \Milhojas\Domain\Contents\PostStates\RetiredPostState();
	}

}
?>

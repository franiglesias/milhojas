<?php

namespace Domain\Contents\PostStates;
use Domain\Contents\PostStates\AbstractPostState;

/**
* Describes a Post not published
*/
class PublishedPostState extends AbstractPostState
{
	public function retire()
	{
		return new \Domain\Contents\PostStates\RetiredPostState();
	}

}
?>
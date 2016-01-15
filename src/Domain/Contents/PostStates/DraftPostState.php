<?php

namespace Domain\Contents\PostStates;
use Domain\Contents\PostStates\AbstractPostState;

/**
* Describes a Post not published
*/
class DraftPostState extends AbstractPostState
{
	public function publish()
	{
		return new \Domain\Contents\PostStates\PublishedPostState();
	}

}
?>
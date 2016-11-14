<?php

namespace Milhojas\Domain\Contents\PostStates;

class AbstractPostState {
	public function publish()
	{
		throw new \UnderflowException('Publish is not supported');
	}
	
	public function retire()
	{
		throw new \UnderflowException('Retire is not supported');
	}
	
}
?>

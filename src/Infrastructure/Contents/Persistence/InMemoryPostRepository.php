<?php

namespace Infrastructure\Contents\Persistence;

use Domain\Contents\PostRepositoryInterface;

class InMemoryPostRepository implements PostRepositoryInterface {
	private $posts;
	
	public function get(\Domain\Contents\PostId $id)
	{
		if (!isset($this->posts[$id->getId()])) {
			throw new \Domain\Contents\Exceptions\NotFoundPostException($id->getId().' doesn\t exists.');
		}
		return $this->posts[$id->getId()];
	}
	
	public function save(\Domain\Contents\Post $Post)
	{
		$id = $Post->getId()->getId();
		$this->posts[$id] = $Post;
	}
	
	public function countAll()
	{
		return count($this->posts);
	}
}

?>
<?php

namespace Milhojas\Application\Contents;

use Milhojas\Application\Command;
use Milhojas\Application\CommandHandler;
use Milhojas\Domain\Contents\PostRepository;

use Milhojas\Domain\Contents\Post;
use Milhojas\Domain\Contents\PostId;
use Milhojas\Domain\Contents\PostContent;

/**
* Description
*/
class UpdatePostHandler implements CommandHandler
{
	private $repository;
	
	public function __construct(PostRepository $repository)
	{
		$this->repository = $repository;
	}
	
	public function handle(Command $command)
	{
		$Post = $this->repository->get(new PostId($command->getId()));
		$Post->update(new PostContent($command->getTitle(), $command->getBody()));
		$this->repository->save($Post);
	}
}


?>
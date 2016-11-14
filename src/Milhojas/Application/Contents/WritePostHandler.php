<?php

namespace Milhojas\Application\Contents;

use Milhojas\Library\CommandBus\Command;
use Milhojas\Library\CommandBus\CommandHandler;
use Milhojas\Domain\Contents\PostRepository;

use Milhojas\Domain\Contents\Post;
use Milhojas\Domain\Contents\PostId;
use Milhojas\Domain\Contents\PostContent;

use Milhojas\Library\EventBus\EventRecorder;

/**
* Write a new Post with title and content
*/
class WritePostHandler implements CommandHandler
{
	private $repository;
	private $recorder;
	
	public function __construct(PostRepository $repository, EventRecorder $recorder)
	{
		$this->repository = $repository;
		$this->recorder = $recorder;
	}
	
	public function handle(Command $command)
	{
		$Post = Post::write(new PostId($command->getId()), new PostContent($command->getTitle(), $command->getBody()));
		$this->recorder->load($Post->retrieveEvents());
		$this->repository->save($Post);
	}
}


?>

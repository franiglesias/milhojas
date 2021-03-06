<?php

namespace Milhojas\Domain\Contents;

use Milhojas\Domain\Contents\PostId;
use Milhojas\Domain\Contents\PostStates as States;

use Milhojas\Library\ValueObjects\Dates\DateRange;

use Milhojas\EventSourcing\Domain\EventSourcedEntity;

/**
* Represents a Post or article
*/

class Post extends EventSourcedEntity
{
	private $id;
	
	private $state;
	
	private $publication;
	
	
	protected function __construct()
	{
		$this->state = new States\DraftPostState();
		$this->publication = new DateRange(new \DateTimeImmutable());
	}
	
	public static function write(PostId $id, PostContent $content, $author = '')
	{
		$post = new self();
		$post->id = $id;
		$post->recordThat(new Events\NewPostWasWritten($id->getId(), $content->getTitle(), $content->getBody(), $author));
		return $post;
	}

	protected function applyNewPostWasWritten(Events\NewPostWasWritten $event)
	{
		$this->id = new PostId($event->getId());
		$this->content = new PostContent($event->getTitle(), $event->getBody());
		$this->author = $event->getAuthor();
	}
	
	public function update(PostContent $newContent, $author = '')
	{
		$this->recordThat(new Events\PostWasUpdated($this->getId(), $newContent->getTitle(), $newContent->getBody(), $author));
	}
	
	protected function applyPostWasUpdated(Events\PostWasUpdated $event)
	{
		$this->content = new PostContent($event->getTitle(), $event->getBody());
		$this->author = $event->getAuthor();
	}
	
	public function publish(DateRange $publication)
	{
		$this->state = $this->state->publish();
		$this->recordThat(new Events\PostWasPublished($this->getId(), $publication->getStart(), $publication->getEnd()));
	}
	
	protected function applyPostWasPublished(Events\PostWasPublished $event)
	{
		$this->publication = new DateRange($event->getPublication(), $event->getExpiration());
		$this->state = new States\PublishedPostState();
	}
	
	public function isPublished(\DateTimeImmutable $Date = null)
	{
		if (!$Date) {
			$Date = new \DateTimeImmutable();
		}
		return ($this->state == new States\PublishedPostState()) && $this->publication->includes($Date);
	}
			
	public function retire()
	{
		$this->state = $this->state->retire();
		$this->recordThat(new Events\PostWasRetired($this->getId()));
	}
	
	protected function applyPostWasRetired(Events\PostWasRetired $event)
	{
		$this->state = new States\RetiredPostState();
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getState()
	{
		return $this->state;
	}
	
}

?>

<?php

namespace Milhojas\Domain\Contents;

use Milhojas\Domain\Contents\PostId;
use Milhojas\Domain\Contents\PostStates as States;
use Milhojas\Domain\Contents\DTO\PostDTO as PostDTO;

use Milhojas\Library\ValueObjects\Dates\DateRange;

use Milhojas\Library\EventSourcing\Domain\EventSourcedEntity;
use Milhojas\Library\EventSourcing\EventStream\EventStream;
/**
* Represents a Post (an article)
*/
class Post extends EventSourcedEntity
{
	private $id;
	private $content;
	
	private $state;
	
	private $publication;
	
	private $flags;
	
	private $tags;
	private $authors;
	private $attachments;
	
	protected function __construct()
	{
		$this->state = new States\DraftPostState();
		$this->flags = new Flags\FlagCollection(new \SplObjectStorage());
		$this->publication = new DateRange(new \DateTimeImmutable());
	}
	
	static function write(PostId $id, PostContent $content, $author = '')
	{
		$post = new self();
		$post->id = $id;
		$post->recordThat(new Events\NewPostWasWritten($id->getId(), $content->getTitle(), $content->getBody(), $author));
		return $post;
	}

	protected function applyNewPostWasWritten(Events\NewPostWasWritten $event)
	{
		$this->id = new PostId($event->getEntityId());
		$this->content = new PostContent($event->getTitle(), $event->getBody());
		$this->author = $event->getAuthor();
	}
	
	public function update(PostContent $newContent, $author = '')
	{
		$this->recordThat(new Events\PostWasUpdated($this->getEntityId(), $newContent->getTitle(), $newContent->getBody(), $author));
	}
	
	protected function applyPostWasUpdated(Events\PostWasUpdated $event)
	{
		$this->content = new PostContent($event->getTitle(), $event->getBody());
		$this->author = $event->getAuthor();
	}
	
	public function publish(DateRange $publication)
	{
		$this->state = $this->state->publish();
		$this->recordThat(new Events\PostWasPublished($this->getEntityId(), $publication->getStart(), $publication->getEnd()));
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
		$this->recordThat(new Events\PostWasRetired($this->getEntityId()));
	}
	
	protected function applyPostWasRetired(Events\PostWasRetired $event)
	{
		$this->state = new States\RetiredPostState();
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getEntityId()
	{
		return $this->id->getId();
	}
	
	public function getState()
	{
		return $this->state;
	}
	
}

?>
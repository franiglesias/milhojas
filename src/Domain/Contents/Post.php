<?php

namespace Domain\Contents;

use Domain\Contents\PostId;
use Domain\Contents\PostStates as States;

use Library\ValueObjects\Dates\PublicationDateRange;
/**
* Represents a Post (an article)
*/
class Post
{
	private $id;
	private $title;
	private $body;
	
	private $state;
	
	private $pubDate;
	private $featured;
	private $sticky;
	
	function __construct(PostId $id, $title, $body)
	{
		$this->id = $id;
		$this->title = $title;
		$this->body = $body;
		$this->state = new States\DraftPostState();
		$this->featured = false;
		$this->sticky = false;
	}
	
	static function write(PostId $id, $title, $body)
	{
		return new self($id, $title, $body);
	}
	
	public function publish(PublicationDateRange $pubDate)
	{
		$this->state = $this->state->publish();
		$this->pubDate = $pubDate;
	}
	
	public function isPublished(\DateTimeImmutable $Date = null)
	{
		if (!$Date) {
			$Date = new \DateTimeImmutable();
		}
		return ($this->state == new \Domain\Contents\PostStates\PublishedPostState()) && $this->pubDate->includes($Date);
	}
	
	public function flagAsFeatured($featured = true)
	{
		$this->featured = $featured;
	}
	
	public function flagAsSticky($sticky = true)
	{
		$this->sticky = $sticky;
	}
	
	public function retire()
	{
		$this->state = $this->state->retire();
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
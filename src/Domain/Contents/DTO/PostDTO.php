<?php

namespace Milhojas\Domain\Contents\DTO;

use Doctrine\ORM\Mapping as ORM;
use Milhojas\Domain\Contents\DTO\PostContentDTO;

/**
 * @ORM\Entity
 * @ORM\Table(name="post")
 */
class PostDTO implements \Milhojas\Library\Mapper\PopulatedFromMapper
{
    /**
     * @ORM\Column(type="string")
     * @ORM\Id
     */
	protected $id;
	
	/** @ORM\Embedded(class = "PostContentDTO", columnPrefix = false) */
	protected $content;
	
	/** @ORM\Column(type="datetime") */
	protected $pubDate;
	/** @ORM\Column(type="datetime", nullable=TRUE) */
	protected $expiration;
	
	protected $state;
	
	public function __construct()
	{
		$this->content = new PostContentDTO();
	}
	
	public function fromMap($map)
	{
		$this->id = $map['post.id'];
		$this->content->setTitle($map['post.content.title']);
		$this->content->setBody($map['post.content.body']);
		$this->content->setState($map['post.content.state']);
	}

	public function setId($id)
	{
		$this->id = $id;
	}
    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    } 
    /**
     * Set pubDate
     *
     * @param \DateTime $pubDate
     *
     * @return Post
     */
    public function setPubDate($pubDate)
    {
        $this->pubDate = $pubDate;

        return $this;
    }

    /**
     * Get pubDate
     *
     * @return \DateTime
     */
    public function getPubDate()
    {
        return $this->pubDate;
    }

    /**
     * Set expiration
     *
     * @param \DateTime $expiration
     *
     * @return Post
     */
    public function setExpiration($expiration)
    {
        $this->expiration = $expiration;

        return $this;
    }

    /**
     * Get expiration
     *
     * @return \DateTime
     */
    public function getExpiration()
    {
        return $this->expiration;
    }



    /**
     * Set content
     *
     * @param \Milhojas\Domain\Contents\DTO\PostContentDTO $content
     *
     * @return PostDTO
     */
    public function setContent(\Domain\Contents\DTO\PostContentDTO $content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return \Milhojas\Domain\Contents\DTO\PostContentDTO
     */
    public function getContent()
    {
        return $this->content;
    }
	
	public function getState()
	{
		return $this->state;
	}
	
	public function setState($state)
	{
		$this->state = $state;
	}
}

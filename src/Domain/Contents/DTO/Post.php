<?php

namespace Domain\Contents\DTO;

use Doctrine\ORM\Mapping as ORM;
use Domain\Contents\DTO\PostContent;

/**
 * @ORM\Entity
 */
class Post
{
    /**
     * @ORM\Column(type="string")
     * @ORM\Id
     */
	protected $id;
	
	/** @ORM\Embedded(class = "PostContent", columnPrefix = false) */
	protected $content;
	
	/** @ORM\Column(type="datetime") */
	protected $pubDate;
	/** @ORM\Column(type="datetime", nullable=TRUE) */
	protected $expiration;
	
	public function __construct()
	{
		$this->content = new PostContent();
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
     * @param \Domain\Contents\DTO\PostContent $content
     *
     * @return Post
     */
    public function setContent(\Domain\Contents\DTO\PostContent $content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return \Domain\Contents\DTO\PostContent
     */
    public function getContent()
    {
        return $this->content;
    }
}

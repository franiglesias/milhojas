<?php

namespace Milhojas\Library\EventSourcing\EventStore;

use Doctrine\ORM\Mapping as ORM;

/**
* Stores an event and metadata needed
*/

/**
 * @ORM\Entity
 * @ORM\Table(name="events")
 */
class Event
{
    /**
     * @ORM\Column(type="string")
     * @ORM\Id
     */
	private $id;

    /**
     * @ORM\Column(type="string")
     */
	private $event_type;
	
    /**
     * @ORM\Column(type="object")
     */
	private $event;
	
    /**
     * @ORM\Column(type="datetime")
     */
	private $time;
	
    /**
     * @ORM\Column(type="integer")
     */
	private $version;

    /**
     * @ORM\Column(type="string")
     */
	private $entity_type;

    /**
     * @ORM\Column(type="string")
     */
	private $entity_id;

    /**
     * @ORM\Column(type="array")
     */
	private $metadata;
	
	function __construct()
	{
	}
	
	public function getId()
	{
		$this->id = $id;
	}
	
	public function setId($id)
	{
		$this->id = $id;
	}
	
	public function getEventType ()
	{
	  return $this->event_type;
	}
	
	public function setEventType ($event_type)
	{
	  $this->event_type = $event_type;
	}
	
	public function setEvent ($event)
	{
	  $this->event = $event;
	}
	
	public function getEvent ()
	{
	  return $this->event;
	}
	
	public function setVersion ($version)
	{
	  $this->version = $version;
	}
	
	public function getVersion ()
	{
	  return $this->version;
	}
	
	public function setEntityType ($entity_type)
	{
	  $this->entity_type = $entity_type;
	}
	
	public function getEntityType ()
	{
	  return $this->entity_type;
	}
	
	public function setEntityId ($entity_id)
	{
	  $this->entity_id = $entity_id;
	}
	
	public function getEntityId ()
	{
	  return $this->entity_id;
	}
	
	public function setMetadata ($metadata)
	{
	  $this->metadata = $metadata;
	}
	
	public function getMetadata ()
	{
	  return $this->metadata;
	}
	
	public function setTime ($time)
	{
	  $this->time = $time;
	}
	
	public function getTime ()
	{
	  return $this->time;
	}

}

?>
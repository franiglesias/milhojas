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
	
}

?>
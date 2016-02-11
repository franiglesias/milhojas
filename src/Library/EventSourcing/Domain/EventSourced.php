<?php

namespace Milhojas\Library\EventSourcing\Domain;

/**
 * An entity that can be Event Sourced
 *
 * @package default
 * @author Francisco Iglesias Gómez
 */

interface EventSourced {
	
	/**
	 * Return the stream of uncommitted envents
	 *
	 * @return EventStream object
	 * @author Fran Iglesias
	 */
	public function getEvents();
	
	
	/**
	 * Return the identity of the entity
	 *
	 * @return Id object
	 * @author Fran Iglesias
	 */
	public function getEntityId();
	
	/**
	 * Returns the version number for the entity
	 * 
	 * -1: the entity has no events applied
	 *  0: initial version
	 *
	 * @return integer
	 * @author Fran Iglesias
	 */
	public function getVersion();
}

?>
<?php

namespace Tests\Infrastructure\Persistence\Contents\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Milhojas\Library\EventSourcing\DTO\EventDTO;
use Milhojas\Library\ValueObjects\Identity\Id;
/**
* Description
*/
class DomainEventDouble implements \Milhojas\Library\EventSourcing\Domain\DomainEvent
{
	private $id;
	
	public function __construct($id)
	{
		$this->id = $id;
	}
	public function getId()
	{
		return $this->id;
	}
}

// https://vincent.composieux.fr/article/test-your-doctrine-repository-using-a-sqlite-database
/**
 * Loads countries data
 */
class ESFixtures extends AbstractFixture
{
    /**
     * Load fixtures
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
	private $eventId;
    public function load(ObjectManager $manager)
    {
        $manager->clear();
        gc_collect_cycles(); // Could be useful if you have a lot of fixtures
		$this->eventId = 0;
		$this->generateEvents($manager, 'Entity', new Id(1), 3);
		$this->generateEvents($manager, 'Other', new Id(1), 4);
		$this->generateEvents($manager, 'Entity', new Id(2), 6);
        $manager->flush();
    }
	
	private function generateEvents($manager, $entity, $id, $maxVersion)
	{
		for ($version=1; $version <= $maxVersion; $version++) { 
			$this->eventId++;
			$event = new EventDTO();

			$event->setId($this->eventId);
			$event->setEventType('DomainEventDouble');
			$event->setEvent(new DomainEventDouble($id));
			$event->setEntityType($entity);
			$event->setEntityId($id->getId());
			$event->setVersion($version);
			$event->setMetadata(array());
			$event->setTime(new \DateTimeImmutable());
			
			$this->addReference(sprintf('test-event-%s-%s-%s', $entity, $id->getId(), $version), $event);
	        $manager->persist($event);
		}
		
	}
	
}
?>
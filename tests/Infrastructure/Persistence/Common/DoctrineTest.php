<?php

// tests/AppBundle/Entity/ProductRepositoryTest.php
namespace Tests\Infrastructure\Persistence\Common\DoctrineTest;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use \Milhojas\Library\EventSourcing\DTO\EventDTO;

class ESRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

	public function test_nothing()
	{
		# code...
	}
    public function dont_test_experiment()
    {
		$event = new EventDTO();
		$event->setId(1);
		$event->setEventType('CreateEvent');
		$event->setEntityType('Entity');
		$event->setEntityId('2');
		$event->setVersion(6);
		$event->setMetadata(array('meta' => 'data', 'other' => 'metadata'));
		$event->setTime(new \DateTime());

		$this->em->persist($event);
		$this->em->flush();
        $eventList = $this->em
            ->getRepository('EventStore:EventDTO')
				->findAll();
		$theEvent = $this->em->getRepository('EventStore:EventDTO')->find('1');
		print_r($theEvent);
        $this->assertCount(1, $eventList);
    }

	public function dont_test_count()
	{
		$qb = $this->em->createQueryBuilder()
			->select('count(events.id)')
			->from('EventStore:EventDTO','events')
			->where('events.entity_type = :entity AND events.entity_id = :id')
				->setParameter('entity', 'Entity')->setParameter('id', '2');
		print_r( $qb->getQuery()->getSingleScalarResult());
		
		
		print_r ($this->em
			->createQuery('SELECT COUNT(events.id) FROM EventStore:EventDTO events WHERE events.entity_type = :entity AND events.entity_id = :id')
			->setParameter('entity', 'Entity')
			->setParameter('id', '2')
			->getSingleScalarResult());
	}
	
	public function dont_test_max()
	{
		print $this->em
					->createQuery('SELECT MAX(events.version) FROM EventStore:EventDTO events WHERE events.entity_type = :entity AND events.entity_id = :id')
					->setParameter('entity', 'Entity')
					->setParameter('id', 2)
					->getSingleScalarResult();
	}

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
    }
}

?>
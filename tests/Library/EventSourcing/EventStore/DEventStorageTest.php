<?php

namespace Tests\Library\EventSourcing\EventStore;

use Tests\Infrastructure\Persistence\Common\DoctrineTestCase;
use Milhojas\Library\EventSourcing\EventStore\DoctrineEventStorage;
use Milhojas\Library\EventSourcing\DTO\EntityData;
/**
 * Test the country repository
 */
class DEventStorageTest extends DoctrineTestCase
{
    /**
     * Set up repository test
     */
    public function setUp()
    {
        $this->loadFixturesFromDirectory(__DIR__ . '/Fixtures');
    }

	public function test_it_loads_stream_with_3_events()
	{
		$storage = new DoctrineEventStorage($this->em);
		$result = $storage->loadStream(new EntityData('Entity', 1, 0));
		$this->assertEquals(3, $result->count());
	}

	public function test_it_loads_other_stream_with_4_events()
	{
		$storage = new DoctrineEventStorage($this->em);
		$result = $storage->loadStream(new EntityData('Other', 1, 0));
		$this->assertEquals(4, $result->count());
	}

	public function test_it_loads_entity_2_stream_with_6_events()
	{
		$storage = new DoctrineEventStorage($this->em);
		$result = $storage->loadStream(new EntityData('Entity', 2, 0));
		$this->assertEquals(6, $result->count());
	}
	
	public function test_it_can_count_enitites_stored()
	{
		$storage = new DoctrineEventStorage($this->em);
		$this->assertEquals(2, $storage->countEntitiesOfType('Entity'));
		$this->assertEquals(1, $storage->countEntitiesOfType('Other'));
	}

	public function test_it_can_count_events_for_an_entity()
	{
		$storage = new DoctrineEventStorage($this->em);
		$this->assertEquals(3, $storage->count(new EntityData('Entity', 1, 0)));
		$this->assertEquals(4, $storage->count(new EntityData('Other', 1, 0)));
		$this->assertEquals(6, $storage->count(new EntityData('Entity', 2, 0)));
	}

    /**
     * Returns repository
     *
     * @return \Eko\MyBundle\Repository\CountryRepository
     */
    protected function getRepository()
    {
        return $this->em->getRepository('\Library\EventSourcing\DTO\EventDAO');
    }
}

?>
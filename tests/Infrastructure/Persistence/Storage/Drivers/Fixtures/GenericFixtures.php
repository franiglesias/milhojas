<?php

namespace Tests\Infrastructure\Persistence\Contents\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

// Aquí poner una Entidad que se pueda usar para Test
use Tests\Infrastructure\Persistence\Storage\Doubles\StoreObject;




// https://vincent.composieux.fr/article/test-your-doctrine-repository-using-a-sqlite-database
/**
 */
class GenericFixtures extends AbstractFixture
{
	private $eventId;

    /**
     * Load fixtures
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
	
    public function load(ObjectManager $manager)
    {
        $manager->clear();
        gc_collect_cycles(); // Could be useful if you have a lot of fixtures
		$this->generateFixtures($manager, 10);
    }

	private function generateFixtures($manager, $total = 5)
	{
		for ($i=1; $i <= $total ; $i++) { 
			$object = new StoreObject($i, 'Object '.$i);
			$manager->persist($object);
			$manager->flush();
			$this->addReference('object-'.$i, $object);
		}
	}
	
}
?>
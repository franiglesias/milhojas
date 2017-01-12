<?php

namespace Tests\Infrastructure\Persistence\Contents\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Milhojas\Domain\Contents\DTO\PostList;
use Milhojas\Library\ValueObjects\Identity\Id;



// https://vincent.composieux.fr/article/test-your-doctrine-repository-using-a-sqlite-database
/**
 */
class PostListFixtures extends AbstractFixture
{

    /**
     * Load fixtures
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
	
    public function load(ObjectManager $manager)
    {
        $manager->clear();
        gc_collect_cycles(); // Could be useful if you have a lot of fixtures
		$this->eventId = 0;
		$manager->persist(new PostList(1, 'Title One'));
		$manager->persist(new PostList(2, 'Title Two'));
        $manager->flush();
    }
	
}
?>

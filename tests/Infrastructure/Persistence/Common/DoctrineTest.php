<?php

// tests/AppBundle/Entity/ProductRepositoryTest.php
namespace Tests\Infrastructure\Persistence\Common\DoctrineTest;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Domain\Contents\DTO\Post;
class PostRepositoryTest extends KernelTestCase
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
    public function xtestSearchByCategoryName()
    {
	     $post = new Post('1348');
	     $post->setTitle('A Foo Bar');
		 $post->setPubDate(new \DateTime());
	     $post->setBody('A body for this test');
		 $post->setExpiration(null);

		$this->em->persist($post);
		$this->em->flush();
        $postList = $this->em
            ->getRepository('Contents:Post')
				->findAll()
        ;
		$thePost = $this->em->getRepository('Contents:Post')->find('1234');
		print_r($thePost);
        $this->assertCount(1, $postList);
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
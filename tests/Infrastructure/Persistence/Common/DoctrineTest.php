<?php

// tests/AppBundle/Entity/ProductRepositoryTest.php
namespace Tests\Infrastructure\Persistence\Common\DoctrineTest;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Domain\Contents\DTO\PostDTO;
use Domain\Contents\DTO\PostContentDTO;
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
    public function dont_test_experiment()
    {
		$content = new PostContentDTO();
		$content->setTitle('A title');
		$content->setBody('A New Body');
		
	     $post = new PostDTO();
		 $post->setId('89654');
	     $post->setContent($content);
		 $post->setPubDate(new \DateTime());
		 $post->setExpiration(null);

		$this->em->persist($post);
		$this->em->flush();
        $postList = $this->em
            ->getRepository('Contents:PostDTO')
				->findAll()
        ;
		$thePost = $this->em->getRepository('Contents:PostDTO')->find('1234');
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
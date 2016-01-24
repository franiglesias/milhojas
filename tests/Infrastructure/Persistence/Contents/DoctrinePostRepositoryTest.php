<?php

namespace Tests\Infrastructure\Persistence\Contents;

use Infrastructure\Persistence\Contents\DoctrinePostRepository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;

class DoctrinePostRespositoryTest extends \PHPUnit_Framework_TestCase
{
	
	protected function getRepository()
	{
        $postRepository = $this
            ->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        // $postRepository->expects($this->once())
        //     ->method('find')
        //     ->will($this->returnValue(new \Domain\Contents\DTO\Post()));
		return $postRepository;
	}
    protected function getEmMock()
    {   
        // Last, mock the EntityManager to return the mock of the repository
        $entityManager = $this
            ->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
           ->getMock();
        $entityManager->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($this->getRepository()));
		return $entityManager;
     }
	 
	 public function test_it_creates_doctrine_repository()
	 {
		 $MockedRepo = $this->getRepository();
		 $repo = new DoctrinePostRepository($MockedRepo);
		 $this->assertAttributeEquals($MockedRepo, 'Repository', $repo);
	 }
	 
	 public function test_it_can_store_a_record()
	 {
		 $MockedRepo = $this->getRepository();
		 $repo = new DoctrinePostRepository($MockedRepo);
		 $Post = $this->getMockBuilder('Domain\Contents\Post')
			 ->disableOriginalConstructor()
			 ->getMock();
		 $repo->save($Post);
		 $this->assertEquals(1, $repo->countAll());
		 
	 }
}

?>
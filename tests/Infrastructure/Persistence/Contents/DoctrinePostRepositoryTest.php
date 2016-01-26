<?php

namespace Tests\Infrastructure\Persistence\Contents;

use Infrastructure\Persistence\Contents\DoctrinePostRepository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;

use Domain\Contents\Post;
use Domain\Contents\DTO\Post as PostDTO;



class DoctrinePostRespositoryTest extends \PHPUnit_Framework_TestCase
{
	
	public function getPost()
	{
		$post = $this->getMockBuilder('Domain\Contents\Post')
			->disableOriginalConstructor()
			->getMock();
		return $post;
	}
	
	protected function getRepository()
	{
        $postRepository = $this
            ->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
		return $postRepository;
	}
    protected function getEmMock()
    {   
        // Last, mock the EntityManager to return the mock of the repository
        $entityManager = $this
            ->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        // $entityManager->expects($this->once())
        //     ->method('getRepository')
        //     ->will($this->returnValue($this->getRepository()));
		return $entityManager;
     }
	
	 public function test_it_can_save_post()
	 {
	     $dto = new PostDTO('1348');
	     $dto->setTitle('A Foo Bar');
		 $dto->setPubDate(new \DateTime());
	     $dto->setBody('A body for this test');
		 $dto->setExpiration(null);
		 
		 $post = $this->getPost();
		 $em = $this->getEmMock();

		 // Set expectations
		 
		 $post->expects($this->once())
			 ->method('getAsDto')
			 ->will($this->returnValue($dto));
		 $em->expects($this->once())
			 ->method('persist')->with($this->equalTo($dto));
		 $em->expects($this->once())
			 ->method('flush');

		 $repo = new DoctrinePostRepository($em);
		 $repo->save($post);
	 }
	 
	 public function test_it_can_get_a_post_by_id()
	 {
	     $dto = new PostDTO('1234');
	     $dto->setTitle('A Foo Bar');
		 $dto->setPubDate(new \DateTime());
	     $dto->setBody('A body for this test');
		 $dto->setExpiration(null);
		 
		 $post = $this->getPost();
		 $em = $this->getEmMock();

		 // Set expectations
		 
		 // $post->expects($this->once())
		 // 			 ->method('setAsDto')
		 // 			 ->will($this->returnValue($dto));
		 
         $em->expects($this->once())
             ->method('getRepository')
             ->will($this->returnValue($this->getRepository()));

		 $repo = new DoctrinePostRepository($em);
		 
		 $post = $repo->get(new \Domain\Contents\PostId('1234'));

	 }
	 
	 public function xtest_it_creates_doctrine_repository()
	 {
		 $MockedRepo = $this->getRepository();
		 $repo = new DoctrinePostRepository($MockedRepo);
		 $this->assertAttributeEquals($MockedRepo, 'Repository', $repo);
	 }
	 
	 public function xtest_it_can_store_a_record()
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
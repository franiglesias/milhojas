<?php

namespace Tests\Infrastructure\Persistence\Contents;

use Infrastructure\Persistence\Contents\DoctrinePostRepository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;

use Domain\Contents\DTO\PostDTO;

use Domain\Contents\Post;


class DoctrinePostRespositoryTest extends \PHPUnit_Framework_TestCase
{
	
	public function getPost()
	{
		$post = $this
			->getMockBuilder('Domain\Contents\Post')
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
    protected function getEntityManager()
    {   
        $entityManager = $this
            ->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
		return $entityManager;
     }
	 
	 protected function getQuery()
	 {
		// http://h4cc.tumblr.com/post/61502458780/phpunit-mock-for-doctrineormquery
		 
	 	$query = $this
			->getMockBuilder('Doctrine\ORM\AbstractQuery')
			->setMethods(array('getResult', 'setParameter', 'getSingleScalarResult'))
			->disableOriginalConstructor()
			->getMockForAbstractClass();
		return $query;
	 }
	 
	 public function getMapper()
	 {
	 	$mapper = $this
			->getMockBuilder('Domain\Contents\PostMapper')
				->disableOriginalConstructor()
					->getMock();
		return $mapper;
	 }
	
	 public function test_it_can_save_post()
	 {
	     $dto = new PostDTO();
		 $dto->setId('1234');
	     $dto->setContent(new \Domain\Contents\DTO\PostContentDTO('A Foo Bar', 'A body for this test'));
		 $dto->setPubDate(new \DateTime());

		 $dto->setExpiration(null);
		 
		 $post = $this->getPost();
		 $em = $this->getEntityManager();

		 // Set expectations
		 
		 $mapper = $this->getMapper();
		 $mapper->expects($this->once())
			 ->method('map')->with($this->equalTo($post), $this->equalTo(new PostDTO()))
				 ->will($this->returnValue($dto));
		 
		 $em->expects($this->once())
			 ->method('persist')->with($this->equalTo($dto));
		 $em->expects($this->once())
			 ->method('flush');

		 $repo = new DoctrinePostRepository($em, $mapper);
		 $repo->save($post);
	 }
	 
	 public function test_it_can_count_all()
	 {
	 	$em = $this->getEntityManager();
		$q = $this->getQuery();
		
		$em->expects($this->once())
			->method('createQuery')
			->with($this->equalTo('SELECT COUNT(post.id) FROM Contents:Post post'))
			->will($this->returnValue($q)
		);
		$q->expects($this->once())
			->method('getSingleScalarResult')
			->will($this->returnValue(4));
		
		$repo = new DoctrinePostRepository($em, $this->getMapper());
		$this->assertEquals(4, $repo->countAll());
		
	 }
	 

}

?>
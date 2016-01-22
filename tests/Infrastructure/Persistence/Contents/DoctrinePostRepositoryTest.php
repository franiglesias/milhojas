<?php

namespace Tests\Infrastructure\Persistence\Contents;

use Infrastructure\Persistence\Contents\DoctrinePostRepository;


// use AppBundle\Salary\SalaryCalculator;
// use AppBundle\Entity\Employee;
// use Doctrine\ORM\EntityRepository;
// use Doctrine\Common\Persistence\ObjectManager;
//
// class SalaryCalculatorTest extends \PHPUnit_Framework_TestCase
// {
//     public function testCalculateTotalSalary()
//     {
//         // First, mock the object to be used in the test
//         $employee = $this->getMock(Employee::class);
//         $employee->expects($this->once())
//             ->method('getSalary')
//             ->will($this->returnValue(1000));
//         $employee->expects($this->once())
//             ->method('getBonus')
//             ->will($this->returnValue(1100));
//
//         // Now, mock the repository so it returns the mock of the employee
//         $postRepository = $this
//             ->getMockBuilder(EntityRepository::class)
//             ->disableOriginalConstructor()
//             ->getMock();
//         $postRepository->expects($this->once())
//             ->method('find')
//             ->will($this->returnValue($employee));
//
//         // Last, mock the EntityManager to return the mock of the repository
//         $entityManager = $this
//             ->getMockBuilder(ObjectManager::class)
//             ->disableOriginalConstructor()
//             ->getMock();
//         $entityManager->expects($this->once())
//             ->method('getRepository')
//             ->will($this->returnValue($postRepository));
//
//         $salaryCalculator = new SalaryCalculator($entityManager);
//         $this->assertEquals(2100, $salaryCalculator->calculateTotalSalary(1));
//     }
// }
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Persistence\ObjectManager;

class DoctrinePostRespositoryTest extends \PHPUnit_Framework_TestCase
{
    protected function getEmMock()
    {   
        // Now, mock the repository so it returns the mock of the employee
        $postRepository = $this
            ->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $postRepository->expects($this->once())
            ->method('find')
            ->will($this->returnValue(new \Infrastructure\Persistence\Doctrine\Post()));

        // Last, mock the EntityManager to return the mock of the repository
        $entityManager = $this
            ->getMockBuilder('\Doctrine\Common\Persistence\ObjectManager')
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($postRepository));
		return $entityManager;
     }
	 
	 public function test_it_creates_doctrine_repository()
	 {
		 $EntityManager = $this->getEmMock();
		 $repo = new DoctrinePostRepository($EntityManager);
		 
	 }
}

?>
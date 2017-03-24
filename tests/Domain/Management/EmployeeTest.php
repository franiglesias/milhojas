<?php

namespace Tests\Domain\Management\Employee;

# SUT

use Milhojas\Domain\Management\Employee;


/**
* Test Employee
*/
class EmployeeTest extends \PHPUnit_Framework_TestCase
{
	public function testCreateEmployee()
	{
		$employee = new Employee('email@example.com', 'Fran', 'Iglesias', 'male', array(123456));
	}
	
	public function testItReturnsRightFullName()
	{
		$employee = new Employee('email@example.com', 'Fran', 'Iglesias', 'male', array(123456));
		$this->assertEquals('Fran Iglesias', $employee->getFullName());
	}
	
	public function testItReturnsTheRightTreatment()
	{
		$employee = new Employee('email@example.com', 'Fran', 'Iglesias', 'male', array(123456));
		$this->assertEquals('Estimado Fran', $employee->getTreatment());
		
		$employee = new Employee('email@example.com', 'Fran', 'Iglesias', 'female', array(123456));
		$this->assertEquals('Estimada Fran', $employee->getTreatment());
	}
	
	public function testItCanBeCreatedFromYamlArray()
	{
		$data = array(
			'email' => 'email@example.com',
			'firstname' => 'Fran',
			'lastname' => 'Iglesias',
			'gender' => 'male',
			'payrolls' => array(123456)
		);
		$employee = Employee::fromArray($data);
		$expected = new Employee('email@example.com', 'Fran', 'Iglesias', 'male', array(123456));
		$this->assertEquals($expected, $employee);
	}

    public function test_it_returns_payrolls_identificators()
    {
        $employee = new Employee('email@example.com', 'Fran', 'Iglesias', 'female', array(123456));
        $this->assertEquals(['123456'], $employee->getPayrolls());
    }

    public function test_it_returns_email()
    {
        $employee = new Employee('email@example.com', 'Fran', 'Iglesias', 'female', array(123456));
        $this->assertEquals('email@example.com', $employee->getEmail());
    }


}

?>

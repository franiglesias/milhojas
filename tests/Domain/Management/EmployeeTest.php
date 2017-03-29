<?php

namespace Tests\Domain\Management\Employee;

# SUT

use Milhojas\Domain\Management\Employee;
use Milhojas\Library\ValueObjects\Identity\Email;
use Milhojas\Library\ValueObjects\Identity\Person;
use Milhojas\Library\ValueObjects\Misc\Gender;


/**
 * Test Employee
 */
class EmployeeTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateEmployee()
    {
        $employee = new Employee(
            new Email('email@example.com'),
            new Person(
                'Fran',
                'Iglesias',
                new Gender(Gender::MALE)
            ),
            array(123456)
        );
    }

    public function testItReturnsRightFullName()
    {
        $employee = new Employee(
            new Email('email@example.com'),
            new Person(
                'Fran',
                'Iglesias',
                new Gender(Gender::MALE)
            ),
            array(123456)
        );
        $this->assertEquals('Fran Iglesias', $employee->getFullName());
    }


    public function testItCanBeCreatedFromYamlArray()
    {
        $data = array(
            'email' => 'email@example.com',
            'firstname' => 'Fran',
            'lastname' => 'Iglesias',
            'gender' => Gender::MALE,
            'payrolls' => array(123456),
        );
        $employee = Employee::fromArray($data);
        $expected = new Employee(
            new Email('email@example.com'),
            new Person(
                'Fran',
                'Iglesias',
                new Gender(Gender::MALE)
            ),
            array(123456)
        );
        $this->assertEquals($expected, $employee);
    }

    public function test_it_returns_payrolls_identificators()
    {
        $employee = new Employee(
            new Email('email@example.com'),
            new Person(
                'Fran',
                'Iglesias',
                new Gender(Gender::FEMALE)
            ),
            array(123456)
        );
        $this->assertEquals(['123456'], $employee->getPayrolls());
    }

    public function test_it_returns_email()
    {
        $employee = new Employee(
            new Email('email@example.com'),
            new Person(
                'Fran',
                'Iglesias',
                new Gender(Gender::FEMALE)
            ),
            array(123456)
        );
        $this->assertEquals(new Email('email@example.com'), $employee->getEmail());
    }


}

?>

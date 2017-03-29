<?php

namespace Milhojas\Domain\Management;
use Milhojas\Library\ValueObjects\Identity\Email;
use Milhojas\Library\ValueObjects\Identity\Person;
use Milhojas\Library\ValueObjects\Misc\Gender;


/**
 * Represents an Employee for Management Bounded Context. In this context we are interested on a few data:
 *
 * Name and gender to construct personalized messages
 * Payrolls codes to find the appropiate payroll documents
 * An email to send payroll documents when needed
 *
 * Employee is associated to username.
 */
class Employee
{
    /**
     * @var Email
     */
    private $email;
    private $firstname;
    private $lastname;
    private $gender;
    private $payrolls;
    private $person;

    public function __construct(Email $email, Person $person, $payrolls)
    {
        $this->email = $email;
//		$this->firstname = $firstname;
//		$this->lastname  = $lastname;
//		$this->gender    = $gender;
        $this->payrolls = $payrolls;
        $this->person = $person;
    }

    # Named constructors

    /**
     * Creates new Employee from the array of data extracted from a Yaml file
     *
     * @param array $data
     *
     * @return Employee
     * @author Fran Iglesias
     */
    public static function fromArray(array $data)
    {
        return new self(
            new Email($data['email']),
            new Person($data['firstname'], $data['lastname'], new Gender($data['gender'])),
            $data['payrolls']
        );
    }

    /**
     * Returns the array of payroll codes for this employee
     *
     * @return array
     * @author Fran Iglesias
     */
    public function getPayrolls()
    {
        return $this->payrolls;
    }

    public function getFullName()
    {
        return $this->getFirstName().' '.$this->getLastName();
    }

    public function getEmail()
    {
        return $this->email->get();
    }

    public function getGender()
    {
        return $this->person->getGender();
    }

    public function getFirstName()
    {
        return $this->person->getName();
    }

    /**
     * @return string
     */
    protected function getLastname()
    {
        return $this->person->getSurname();
    }

    public function __toString()
    {
        return $this->getFullName();
    }
}

?>

<?php

namespace Milhojas\Domain\Management;
use Milhojas\Library\ValueObjects\Identity\Email;
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

    public function __construct(Email $email, $firstname, $lastname, Gender $gender, $payrolls)
	{
		$this->email     = $email;
		$this->firstname = $firstname;
		$this->lastname  = $lastname;
		$this->gender    = $gender;
		$this->payrolls  = $payrolls;
	}
	
	# Named constructors
	
	/**
	 * Creates new Employee from the array of data extracted from a Yaml file
	 *
	 * @param array $data 
	 * @return void
	 * @author Fran Iglesias
	 */
	public static function fromArray(array $data)
	{
		return new self($data['email'], $data['firstname'], $data['lastname'], $data['gender'], $data['payrolls']);
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
		return $this->email;
	}

    protected function getGender()
	{
        return $this->gender->getGender();
	}

    protected function getFirstName()
	{
		return $this->firstname;
	}

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }
	
	public function getTreatment()
	{
        $treatment = $this->getGender() == Gender::FEMALE ? 'Estimada' : 'Estimado';

        return sprintf('%s %s', $treatment, $this->getFirstName());
	}
	
	public function __toString()
	{
		return $this->getFullName();
	}
}

?>

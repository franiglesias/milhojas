<?php

namespace Milhojas\Infrastructure\Persistence\Management;

# Domain concepts

use Milhojas\Domain\Management\Staff;
use Milhojas\Domain\Management\Employee;

# Exceptions

use Milhojas\Infrastructure\Persistence\Management\Exceptions\EmployeeCouldNotBeFound;

# Utilities

use Symfony\Component\Yaml\Yaml;

/**
* Implements a Staff repository over a Yaml file
*/

class YamlStaff implements Staff
{
	private $path;
	private $employees;
	
	public function __construct($path)
	{
		$this->path = $path;
		$this->employees = $this->loadEmployees();
	}
	
	/**
	 * Returns a Employee identified by Username
	 *
	 * @param string $username 
	 * @return Employee
	 * @author Fran Iglesias
	 */
	public function getEmployeeByUsername($username)
	{
		$this->checkUsername($username);
		return new Employee(
			$username, 
			$this->employees[$username]['firstname'],
			$this->employees[$username]['lastname'],
			$this->employees[$username]['gender'],
			$this->employees[$username]['payroll']
		);
	}
	
	/**
	 * Simply counts records
	 *
	 * @return integer
	 * @author Fran Iglesias
	 */
	public function countAll()
	{
		return count($this->employees);
	}

	/**
	 * Loads the employees data
	 *
	 * @return array
	 * @author Fran Iglesias
	 */
	private function loadEmployees()
	{
		$employees = Yaml::parse(file_get_contents($this->path));
		return $employees;
	}
	
	/**
	 * Throws exception if username could not be found
	 *
	 * @param string $username 
	 * @return void
	 * @author Fran Iglesias
	 */
	private function checkUsername($username)
	{
		if (! isset($this->employees[$username])) {
			throw new EmployeeCouldNotBeFound(sprintf('Employee identified by %s could not be found', $username), 1);
		}
	}
	
}
?>

<?php

namespace Milhojas\Infrastructure\Persistence\Management;

# Domain concepts

use Milhojas\Domain\Management\Employee;
use Milhojas\Domain\Management\Staff;
use Milhojas\Infrastructure\Persistence\Management\Exceptions\EmployeeCouldNotBeFound;
use Milhojas\Library\ValueObjects\Identity\Email;
use Milhojas\Library\ValueObjects\Identity\Person;
use Milhojas\Library\ValueObjects\Identity\Username;
use Milhojas\Library\ValueObjects\Misc\Gender;
use Symfony\Component\Yaml\Yaml;


# Exceptions

# Utilities


/**
 * Implements a Staff repository over a Yaml file
 */
class YamlStaff implements Staff
{
    /**
     * Path to YAML file
     * @var string
     */
    private $path;
    /**
     * @var Employee[]
     */
    private $employees;

    /**
     * YamlStaff constructor.
     *
     * @param $path string to the YAML file storing data
     */
    public function __construct($path)
    {
        $this->path = $path;
        $this->loadEmployees();
    }

    /**
     * Returns a Employee identified by Username
     *
     * @param Username $username
     *
     * @return Employee
     * @author Fran Iglesias
     */
    public function getEmployeeByUsername(Username $username)
    {
        $this->checkUsername($username->get());

        return $this->employees[$username->get()];
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->employees);
    }

    /**
     * Retrieves all employees
     *
     * @return array
     * @author Fran Iglesias
     */
    public function findAll()
    {
        return $this->employees;
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
     * Loads employees data
     *
     * @return void
     * @author Fran Iglesias
     */
    private function loadEmployees()
    {
        $this->employees = array();
        $employees = Yaml::parse(file_get_contents($this->path));
        foreach ($employees as $username => $data) {
            $this->employees[$username] = new Employee(
                new Email($data['email']),
                new Person(
                    $data['firstname'],
                    $data['lastname'],
                    new Gender($data['gender'])
                ),
                $data['payroll']
            );
        }
    }

    /**
     * Throws exception if username could not be found
     *
     * @param string $username
     *
     * @return void
     * @author Fran Iglesias
     */
    private function checkUsername($username)
    {
        if (!isset($this->employees[$username])) {
            throw new EmployeeCouldNotBeFound(sprintf('Employee identified by %s could not be found', $username), 1);
        }
    }

}

?>

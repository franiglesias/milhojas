<?php

namespace Milhojas\Domain\Management;

use Milhojas\Domain\Management\Employee;

/**
 * Represent a repository for payroll files. It could be the FileSystem or a zip file
 *
 * @author Fran Iglesias
 */
interface Payrolls {
	public function getForEmployee(Employee $employee, $repositories, $month);
}

?>

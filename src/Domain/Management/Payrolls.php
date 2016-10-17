<?php

namespace Milhojas\Domain\Management;

use Milhojas\Domain\Management\Employee;

interface Payrolls {
	public function getByMonthAndEmployee($month, Employee $employee);
}

?>

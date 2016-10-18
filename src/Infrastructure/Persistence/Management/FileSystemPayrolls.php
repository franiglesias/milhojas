<?php

namespace Milhojas\Infrastructure\Persistence\Management;

# Exceptions

use Milhojas\Infrastructure\Persistence\Management\Exceptions\EmployeeHasNoPayrollFiles;

# Domain concepts

use Milhojas\Domain\Management\Payrolls;
use Milhojas\Domain\Management\PayrollDocument;
use Milhojas\Domain\Management\Employee;

# Utils

use Symfony\Component\Finder\Finder;

/**
* Retrieve PayrollDocuments from the filesystem
*/
class FileSystemPayrolls implements Payrolls
{
	private $basePath;
	
	public function __construct($basePath)
	{
		$this->basePath = $basePath;
	}
	
	public function getByMonthAndEmployee($month, Employee $employee) {
		$finder = new Finder();
		$monthPath = $this->basePath.'/'.$month;
		$pattern = '/trabajador_('.implode('|', $employee->getPayrolls()).')_/';
		$foundFiles = $finder->files()->in($monthPath)->name($pattern);
		if (! iterator_count($foundFiles)) {
			throw new EmployeeHasNoPayrollFiles(sprintf('Employee %s has no payroll files for month %s', $employee->getFullName(), $month));
		}
		$payrollFiles = [];
		foreach ($foundFiles as $file) {
			$payrollFiles[] = new PayrollDocument($file);
		}
		return $payrollFiles;
	}
	
}

?>

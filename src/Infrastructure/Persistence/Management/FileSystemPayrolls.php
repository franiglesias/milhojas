<?php

namespace Milhojas\Infrastructure\Persistence\Management;

use Milhojas\Domain\Management\Payrolls;
use Milhojas\Domain\Management\PayrollDocument;
use Milhojas\Domain\Management\Employee;

use Symfony\Component\Finder\Finder;

use Milhojas\Infrastructure\Persistence\Management\Exceptions\EmployeeHasNoPayrollFiles;

/**
* Retrieve PayrollDocuments from the filesystem
*/
class FileSystemPayrolls implements Payrolls
{
	private $basePath;
	private $finder;
	
	public function __construct($basePath, FInder $finder)
	{
		$this->basePath = $basePath;
		$this->finder = $finder;
	}
	
	public function getByMonthAndEmployee($month, Employee $employee) {
		$pattern = '/trabajador_('.implode('|', $employee->getPayrolls()).')_\d+/';
		$foundFiles = $this->finder->files()->in($this->basePath.'/'.$month)->name($pattern);
		if (! count($foundFiles)) {
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

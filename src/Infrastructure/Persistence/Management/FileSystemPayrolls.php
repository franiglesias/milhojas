<?php

namespace Milhojas\Infrastructure\Persistence\Management;

# Domain concepts

use Milhojas\Domain\Management\Payrolls;
use Milhojas\Domain\Management\PayrollDocument;
use Milhojas\Domain\Management\Employee;

# Exceptions

use Milhojas\Infrastructure\Persistence\Management\Exceptions\EmployeeHasNoPayrollFiles;

# Utils

use Symfony\Component\Finder\Finder;

/**
* Retrieve PayrollDocuments from the filesystem, actings as a Repository
*/
class FileSystemPayrolls implements Payrolls
{
	private $basePath;
	
	public function __construct($basePath)
	{
		$this->basePath = $basePath;
	}
	
	public function getByMonthAndEmployee($month, Employee $employee) {
		$files = $this->getFiles($month, $employee);
		$documents = [];
		foreach ($files as $file) {
			$documents[] = new PayrollDocument($file);
		}
		return $documents;
	}
	
	/**
	 * Retrieves related files from the FileSystem
	 *
	 * @param string $month 
	 * @param Employee $employee 
	 * @return Files Iterator
	 * @author Fran Iglesias
	 */
	private function getFiles($month, Employee $employee)
	{
		$pattern = sprintf('/_trabajador_(%s)_/', implode('|', $employee->getPayrolls()));
		$finder = new Finder();
		$finder->files()->in( $this->basePath.'/'.$month )->name($pattern);
		if (! iterator_count($finder)) {
			throw new EmployeeHasNoPayrollFiles(sprintf('Employee %s has no payroll files for month %s', $employee->getFullName(), $month));
		}
		return $finder;
	}
	
}

?>

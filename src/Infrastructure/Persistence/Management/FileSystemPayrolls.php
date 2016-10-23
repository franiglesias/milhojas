<?php

namespace Milhojas\Infrastructure\Persistence\Management;

# Domain concepts

use Milhojas\Domain\Management\Payrolls;
use Milhojas\Domain\Management\PayrollDocument;
use Milhojas\Domain\Management\Employee;

# Exceptions

use Milhojas\Infrastructure\Persistence\Management\Exceptions\EmployeeHasNoPayrollFiles;
use Milhojas\Infrastructure\Persistence\Management\Exceptions\PayrollRepositoryDoesNotExist;

# Utils

use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;
/**
* Retrieve PayrollDocuments from the filesystem, acting as a Repository
*/
class FileSystemPayrolls implements Payrolls
{
	private $basePath;
	
	public function __construct($basePath)
	{
		$this->checkRepositoryExists($basePath);
		$this->basePath = $basePath;
	}
		
	public function getForEmployee(Employee $employee, $repositories, $month)
	{
		$repositories = $this->prepareRepositories($repositories);
		$documents = [];
		foreach ($repositories as $repo) {
			$files = $this->retrieveFiles($employee, $repo, $month);
			foreach ($files as $file) {
				$documents[] = new PayrollDocument($file);
			}
		}
		return $documents;
	}
	
	private function prepareRepositories($repositories)
	{
		foreach ((array)$repositories as $repo) {
			if (substr($repo, 1) !== '/') {
				$repo = $this->basePath.'/'.$repo;
			}
			$paths[] = $repo;
		}
		return $paths;
	}
	
	/**
	 * Retrieves related files from the FileSystem
	 *
	 * @param string $month 
	 * @param Employee $employee 
	 * @return Files Iterator
	 * @author Fran Iglesias
	 */
	public function retrieveFiles(Employee $employee, $path, $month)
	{
		$this->checkRepositoryExists($path);
		$pattern = sprintf('/_trabajador_(%s)_/', implode('|', $employee->getPayrolls()));
		$finder = (new Finder())->files()->in( $path )->name($pattern);
		if (! iterator_count($finder)) {
			throw new EmployeeHasNoPayrollFiles(sprintf('Employee %s has no payroll files for month %s', $employee->getFullName(), $month));
		}
		return $finder;
	}
	
	private function checkRepositoryExists($path)
	{
		$fs = new FileSystem();
		if (! $fs->exists($path)) {
			throw new PayrollRepositoryDoesNotExist(sprintf('Path %s does not exist.', $path));
		}
	}
		
}

?>

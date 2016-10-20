<?php

namespace Milhojas\Infrastructure\Persistence\Management;

# Domain concepts

use Milhojas\Domain\Management\Payrolls;
use Milhojas\Domain\Management\PayrollDocument;
use Milhojas\Domain\Management\Employee;

# Exceptions

use Milhojas\Infrastructure\Persistence\Management\Exceptions\EmployeeHasNoPayrollFiles;
use Milhojas\Infrastructure\Persistence\Management\Exceptions\PayrollRepositoryDoesNotExist;
use Milhojas\Infrastructure\Persistence\Management\Exceptions\PayrollRepositoryForMonthDoesNotExist;

# Utils

use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;

# Zip Extractor

use Mmoreram\Extractor\Filesystem\SpecificDirectory;
use Mmoreram\Extractor\Resolver\ExtensionResolver;
use Mmoreram\Extractor\Extractor;

/**
* Retrieve PayrollDocuments from zip archives, acting as a Repository
*/
class ZipPayrolls implements Payrolls
{
	private $basePath;
	
	public function __construct($basePath)
	{
		$this->checkThatBasePathExists($basePath);
		$this->basePath = $basePath;
	}
	
	/**
	 * Gets the PayrollDocument for an Employee
	 *
	 * @param string $month 
	 * @param Employee $employee 
	 * @return array of PayrollDocument
	 * @author Fran Iglesias
	 */
	
	public function getByMonthAndEmployee($month, Employee $employee) {
		$files = $this->getFiles($month, $employee);
		$documents = [];
		foreach ($files as $file) {
			$documents[] = new PayrollDocument($file);
		}
		return $documents;
	}
	
	/**
	 * Retrieves related files from the ZIP archive
	 *
	 * @param string $month 
	 * @param Employee $employee 
	 * @return Files Iterator
	 * @author Fran Iglesias
	 */
	private function getFiles($month, Employee $employee)
	{
		$pattern = sprintf('/_trabajador_(%s)_/', implode('|', $employee->getPayrolls()));
		$finder = $this->getPayrollFiles($month)->name($pattern);
		if (! iterator_count($finder)) {
			throw new EmployeeHasNoPayrollFiles(sprintf('Employee %s has no payroll files for month %s', $employee->getFullName(), $month));
		}
		return $finder;
	}
	
	/**
	 * Extract files and get a Finder for month
	 *
	 * @param string $month 
	 * @return Finder
	 * @author Fran Iglesias
	 */
	private function getPayrollFiles($month)
	{
		$paths = $this->getPathToArchives($month);
		$extractor = new Extractor(
		    $this->createDirectory($month),
		    new ExtensionResolver
		);
		foreach ($paths as $path) {
			$extractor->extractFromFile($path);
		}
		return (new Finder())->files()->in($this->basePath.'/'.$month);
	}
	
	/**
	 * Creates the directory to extract compressed files
	 * 
	 * Should be removed after completion
	 *
	 * @param string $month 
	 * @return void
	 * @author Fran Iglesias
	 */
	private function createDirectory($month)
	{
		$fs = new FileSystem();
		$fs->mkdir($this->basePath.'/'.$month);
		return new SpecificDirectory($this->basePath.'/'.$month);
	}
	
	/**
	 * Checks that the base route to the repository exists
	 *
	 * @param string $basePath 
	 * @return void
	 * @throws PayrollRepositoryDoesNotExist if route is not found
	 * @author Fran Iglesias
	 */
	private function checkThatBasePathExists($basePath)
	{
		$fs = new FileSystem();
		if (! $fs->exists($basePath)) {
			throw new PayrollRepositoryDoesNotExist(sprintf('Path %s does not exist.', $basePath));
		}
	}
	
	/**
	 * Gets the paths to the zip archives. This archives should start with the name of the desired month
	 *
	 * @param string $month 
	 * @return array of strings
	 * @throws PayrollRepositoryForMonthDoesNotExist if no files are foun
	 * @author Fran Iglesias
	 */
	private function getPathToArchives($month)
	{
		$finder = (new Finder())->files()->in($this->basePath)->name('/^'.$month.'([^\.]*)?\.zip$/');
		if (! count($finder)) {
			throw new PayrollRepositoryForMonthDoesNotExist(sprintf('Archive(s) %s.zip do(es) not exist in %s.', $month, $this->basePath));
		}
		foreach ($finder as $file) {
			$paths[] = $file->getPathName();
		}
		return $paths;
	}
	
}

?>

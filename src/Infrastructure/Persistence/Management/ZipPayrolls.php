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
	 * @param Employee $employee 
	 * @param array|string $repositories paths to the zip archives to proccess
	 * @param string $month 
	 * @return array of PayrollDocument
	 * @author Fran Iglesias
	 */
	
	public function getForEmployee(Employee $employee, $repositories, $month)
	{
		$repositories = $this->prepareRepositories($repositories);
		$documents = [];
			$files = $this->retrieveFiles($employee, $repositories, $month);
			foreach ($files as $file) {
				$documents[] = new PayrollDocument($file);
			}
			return $documents;
	}

	/**
	 * Normalizes all paths to absolute paths
	 *
	 * @param string $repositories 
	 * @return void
	 * @author Francisco Iglesias Gómez
	 */
	private function prepareRepositories($repositories)
	{
		foreach ((array)$repositories as $repo) {
			if (substr($repo, 1) !== '/') {
				$repo = $this->basePath.'/'.$repo;
			}
			$this->checkRepositoryExists($repo);
			$paths[] = $repo;
		}
		return $paths;
	}
	
	/**
	 * Retrieves the files
	 *
	 * @param Employee $employee 
	 * @param string $paths 
	 * @param string $month 
	 * @return void
	 * @author Francisco Iglesias Gómez
	 */
	public function retrieveFiles(Employee $employee, $paths, $month)
	{
		$pattern = sprintf('/_trabajador_(%s)_/', implode('|', $employee->getPayrolls()));
		$finder = $this->getAllPayrollFiles($paths, $month)->name($pattern);
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
	private function getAllPayrollFiles($paths, $month)
	{
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
	
	
	private function checkRepositoryExists($repo)
	{
		$fs = new FileSystem();
		if (! $fs->exists($repo)) {
			throw new PayrollRepositoryDoesNotExist(sprintf('Archive %s does not exist.', $repo));
		}
	}
		
}

?>

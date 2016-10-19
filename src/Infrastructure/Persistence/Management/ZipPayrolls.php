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
use Symfony\Component\Filesystem\Filesystem;

# Zip Extractor

use Mmoreram\Extractor\Filesystem\SpecificDirectory;
use Mmoreram\Extractor\Resolver\ExtensionResolver;
use Mmoreram\Extractor\Extractor;

/**
* Retrieve PayrollDocuments from the filesystem, actings as a Repository
*/
class ZipPayrolls implements Payrolls
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
	 * Retrieves related files from a ZIP file
	 *
	 * @param string $month 
	 * @param Employee $employee 
	 * @return Files Iterator
	 * @author Fran Iglesias
	 */
	private function getFiles($month, Employee $employee)
	{
		$pattern = sprintf('/_trabajador_(%s)_/', implode('|', $employee->getPayrolls()));
		$finder = $this->getExtractor($month);
		$finder->name($pattern);
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
	private function getExtractor($month)
	{
		$dir = $this->createDirectory($month);
		$extractor = new Extractor(
		    $dir,
		    new ExtensionResolver
		);
		$extractor->extractFromFile($this->basePath.'/'.$month.'-concertado.zip');
		$extractor->extractFromFile($this->basePath.'/'.$month.'-no-concertado.zip');
		$finder = new Finder();
		$finder->files()->in($this->basePath.'/'.$month);
		return $finder;
	}
	
	/**
	 * Created the directory to extract compressed files
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
	
}

?>

<?php

namespace Milhojas\Domain\Management;

/**
* Represents a PayRoll Document, usually a PDF file
*/

class PayrollDocument
{
	/**
	 * The path of the document in the FileSystem
	 *
	 * @var string
	 */
	private $file;
	
	public function __construct(\SplFileInfo $file)
	{
		$this->file = $file;
	}
	
	/**
	 * Returns the full path
	 *
	 * @return string
	 * @author Fran Iglesias
	 */
	public function getPath()
	{
		$path = $this->file->getRealPath();
		if (!$path) {
			return $this->file->getPathname();
		}
		return $path;
	}
} 

?>

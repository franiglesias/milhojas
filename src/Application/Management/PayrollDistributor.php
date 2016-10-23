<?php

namespace Milhojas\Application\Management;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
/**
* Represents Distribution of Payroll for a month
*/

/**
 * @Vich\Uploadable
 *
 * @package default
 * @author Francisco Iglesias Gómez
 */
class PayrollDistributor
{
	protected $month;
	protected $completed;
	
	/**
	 * @Vich\UploadableField(mapping="payroll_file", fileNameProperty="fileName")
	 *
	 * @var string
	 */
	protected $file;
	
	protected $fileName;
	
	public function setMonth ($month)
	{
		$this->month = $month;
	}
	
	public function getMonth ()
	{
		return $this->month;
	}
	
	public function setCompleted ($date)
	{
		$this->date = $date;
	}
	
	public function getCompleted ()
	{
		return $this->date;
	}
	
	public function setFile (File $file = null)
	{
		$this->file = $file;
		if ($file) {
			$this->completed = new \DateTime('now');
		}
		return $this;
	}
	
	public function getFile ()
	{
		return $this->file;
	}
	
	public function setFileName ($fileName)
	{
		$this->fileName = $fileName;
		return $this;
	}
	
	public function getFileName ()
	{
		return $this->fileName;
	}
	
	
	
	
}

?>

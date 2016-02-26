<?php


namespace Tests\Infrastructure\Persistence\Management;

use Milhojas\Infrastructure\Persistence\Management\PayrollFile;

class PayrollFileTest extends \PHPUnit_Framework_Testcase {
	
	
	public function test_it_returns_relative_path()
	{
		$path = 'folder/subfolder/file_name.pdf';
		$file = new PayrollFile($path);
		$this->assertEquals('file_name.pdf', $file->getRelativePathName());
	}
}

?>
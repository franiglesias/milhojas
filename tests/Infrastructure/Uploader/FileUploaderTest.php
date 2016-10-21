<?php

namespace Tests\Infrastructure\Uploader;
use Milhojas\Infrastructure\Uploader\FileUploader;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
* Description
*/
class TestUploadedFile extends UploadedFile
{

	public function move($targetDir, $name = null)
	{
	}
	
	public function guessClientExtension()
	{
		return '.ext';
	}
}


/**
* Description
*/
class FileUploaderTest extends \PHPUnit_Framework_Testcase
{
	
	public function test_basic_usage()
	{
		$image = new TestUploadedFile(
		        # Path to the file to send
		        dirname(__FILE__).'/uploads/photo.jpg',
		        # Name of the sent file
		        'photo.jpg',
		        # MIME type
		        'image/jpeg',
		        # Size of the file
		        9988,
				true
		    );
		$uploader = new FileUploader(dirname(__FILE__).'/destination');
		$uploader->upload($image);
	}
}

?>

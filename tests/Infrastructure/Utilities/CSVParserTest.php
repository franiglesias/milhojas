<?php


namespace Tests\Infrastructure\Utilities;

use Milhojas\Infrastructure\Utilities\CSVDataParser;

/**
* Description
*/
class CSVDataParserTest extends \PHPUnit_Framework_Testcase
{
	public function getData()
	{
		return  array(
			'"1","Name","LastName","abc"',
			'"2","Name 2","LastName 2","def"',
			'"3","Name 3","LastName 3","ghi"'
		);
	}
	public function test_it_parses_tabular_data()
	{
		
		$expected = array(
			'1' => array('id' => 1, 'name' => 'Name', 'lastname' => 'LastName', 'code' => 'abc'),
			'2' => array('id' => 2, 'name' => 'Name 2', 'lastname' => 'LastName 2', 'code' => 'def'),
			'3' => array('id' => 3, 'name' => 'Name 3', 'lastname' => 'LastName 3', 'code' => 'ghi'),
		);
		
		$parser = new CSVDataParser(['id', 'name', 'lastname', 'code']);
		$this->assertEquals($expected, $parser->parse($this->getData()));
		
	}
	
	public function test_it_can_ignore_fields()
	{
		
		$expected = array(
			'1' => array('id' => 1, 'name' => 'Name', 'code' => 'abc'),
			'2' => array('id' => 2, 'name' => 'Name 2', 'code' => 'def'),
			'3' => array('id' => 3, 'name' => 'Name 3', 'code' => 'ghi'),
		);
		
		$parser = new CSVDataParser(['id', 'name', null, 'code']);
		$this->assertEquals($expected, $parser->parse($this->getData()));
		
	}
	
	
	public function test_it_parses_tabular_data_changing_id_field()
	{
		
		$expected = array(
			'abc' => array('id' => 1, 'name' => 'Name', 'lastname' => 'LastName', 'code' => 'abc'),
			'def' => array('id' => 2, 'name' => 'Name 2', 'lastname' => 'LastName 2', 'code' => 'def'),
			'ghi' => array('id' => 3, 'name' => 'Name 3', 'lastname' => 'LastName 3', 'code' => 'ghi'),
		);
		
		$parser = new CSVDataParser(['id', 'name', 'lastname', 'code']);
		$parser->setId('code');
		$this->assertEquals($expected, $parser->parse($this->getData()));
		
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function test_it_throws_exception_if_invalid_id_field_is_specified()
	{
		$parser = new CSVDataParser(['id', 'name', 'lastname', 'code']);
		$parser->setId('fake');
	}
	
}
?>
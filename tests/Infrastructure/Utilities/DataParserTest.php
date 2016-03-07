<?php


namespace Tests\Infrastructure\Utilities;

use Milhojas\Infrastructure\Utilities\TabDataParser;

/**
* Description
*/
class DataParserTest extends \PHPUnit_Framework_Testcase
{

	public function test_it_parses_tabular_data()
	{
		$data = array(
			'1'.chr(9).'Name'.chr(9).'LastName'.chr(9).'abc',
			'2'.chr(9).'Name 2'.chr(9).'LastName 2'.chr(9).'def',
			'3'.chr(9).'Name 3'.chr(9).'LastName 3'.chr(9).'ghi'
		);
		
		$expected = array(
			'1' => array('id' => 1, 'name' => 'Name', 'lastname' => 'LastName', 'code' => 'abc'),
			'2' => array('id' => 2, 'name' => 'Name 2', 'lastname' => 'LastName 2', 'code' => 'def'),
			'3' => array('id' => 3, 'name' => 'Name 3', 'lastname' => 'LastName 3', 'code' => 'ghi'),
		);
		
		$parser = new TabDataParser(['id', 'name', 'lastname', 'code']);
		$this->assertEquals($expected, $parser->parse($data));
		
	}
	
	public function test_it_can_ignore_fields()
	{
		$data = array(
			'1'.chr(9).'Name'.chr(9).'LastName'.chr(9).'abc',
			'2'.chr(9).'Name 2'.chr(9).'LastName 2'.chr(9).'def',
			'3'.chr(9).'Name 3'.chr(9).'LastName 3'.chr(9).'ghi'
		);
		
		$expected = array(
			'1' => array('id' => 1, 'name' => 'Name', 'code' => 'abc'),
			'2' => array('id' => 2, 'name' => 'Name 2', 'code' => 'def'),
			'3' => array('id' => 3, 'name' => 'Name 3', 'code' => 'ghi'),
		);
		
		$parser = new TabDataParser(['id', 'name', null, 'code']);
		$this->assertEquals($expected, $parser->parse($data));
		
	}
	
	
	public function test_it_parses_tabular_data_changing_id_field()
	{
		$data = array(
			'1'.chr(9).'Name'.chr(9).'LastName'.chr(9).'abc',
			'2'.chr(9).'Name 2'.chr(9).'LastName 2'.chr(9).'def',
			'3'.chr(9).'Name 3'.chr(9).'LastName 3'.chr(9).'ghi'
		);
		
		$expected = array(
			'abc' => array('id' => 1, 'name' => 'Name', 'lastname' => 'LastName', 'code' => 'abc'),
			'def' => array('id' => 2, 'name' => 'Name 2', 'lastname' => 'LastName 2', 'code' => 'def'),
			'ghi' => array('id' => 3, 'name' => 'Name 3', 'lastname' => 'LastName 3', 'code' => 'ghi'),
		);
		
		$parser = new TabDataParser(['id', 'name', 'lastname', 'code']);
		$parser->setId('code');
		$this->assertEquals($expected, $parser->parse($data));
		
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function test_it_throws_exception_if_invalid_id_field_is_specified()
	{
		$parser = new TabDataParser(['id', 'name', 'lastname', 'code']);
		$parser->setId('fake');
		
	}
	
}
?>
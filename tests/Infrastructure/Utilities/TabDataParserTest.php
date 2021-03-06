<?php


namespace Tests\Infrastructure\Utilities;

use Milhojas\Infrastructure\Utilities\TabDataParser;

/**
* Description
*/
class TabDataParserTest extends \PHPUnit_Framework_Testcase
{
	private function getData()
	{
		return array(
			'1'.chr(9).'Name'.chr(9).'LastName'.chr(9).'abc',
			'2'.chr(9).'Name 2'.chr(9).'LastName 2'.chr(9).'def'.chr(10),
			'3'.chr(9).'Name 3'.chr(9).'LastName 3'.chr(9).'ghi'
		);
	}
	public function test_it_parses_tabular_data()
	{
		$expected = array(
			'1' => array('id' => 1, 'name' => 'Name', 'lastname' => 'LastName', 'code' => 'abc'),
			'2' => array('id' => 2, 'name' => 'Name 2', 'lastname' => 'LastName 2', 'code' => 'def'),
			'3' => array('id' => 3, 'name' => 'Name 3', 'lastname' => 'LastName 3', 'code' => 'ghi'),
		);
		
		$parser = new TabDataParser(['id', 'name', 'lastname', 'code']);
		$this->assertEquals($expected, $parser->parse($this->getData()));
	}
	
	public function test_it_can_ignore_fields()
	{
		$expected = array(
			'1' => array('id' => 1, 'name' => 'Name', 'code' => 'abc'),
			'2' => array('id' => 2, 'name' => 'Name 2', 'code' => 'def'),
			'3' => array('id' => 3, 'name' => 'Name 3', 'code' => 'ghi'),
		);
		
		$parser = new TabDataParser(['id', 'name', null, 'code']);
		$this->assertEquals($expected, $parser->parse($this->getData()));
	}
	
	
	public function test_it_parses_tabular_data_changing_id_field()
	{
		$expected = array(
			'abc' => array('id' => 1, 'name' => 'Name', 'lastname' => 'LastName', 'code' => 'abc'),
			'def' => array('id' => 2, 'name' => 'Name 2', 'lastname' => 'LastName 2', 'code' => 'def'),
			'ghi' => array('id' => 3, 'name' => 'Name 3', 'lastname' => 'LastName 3', 'code' => 'ghi'),
		);
		
		$parser = new TabDataParser(['id', 'name', 'lastname', 'code']);
		$parser->setId('code');
		$this->assertEquals($expected, $parser->parse($this->getData()));
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

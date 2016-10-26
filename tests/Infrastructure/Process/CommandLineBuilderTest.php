<?php

namespace Tests\Infrastructure\Process;


use Milhojas\Infrastructure\Process\CommandLineBuilder;
/**
* Description
*/
class CommandLineBuilderTest extends \PHPUnit_Framework_Testcase
{
	
	public function test_It_creates_a_line_with_no_arguments()
	{
		$clb = new CommandLineBuilder('console:command');
		$this->assertEquals('nohup php bin/console console:command', $clb->line());
	}
	
	public function test_It_creates_a_line_with_argument()
	{
		$clb = (new CommandLineBuilder('console:command'))->withArgument('argument');
		$this->assertEquals('nohup php bin/console console:command argument', $clb->line());
	}

	public function test_It_creates_a_line_with_output()
	{
		$clb = (new CommandLineBuilder('console:command'))->outputTo('file.log');
		$this->assertEquals('nohup php bin/console console:command > file.log', $clb->line());
	}

	public function test_It_creates_a_line_with_enviroment()
	{
		$clb = (new CommandLineBuilder('console:command'))->environment('dev');
		$this->assertEquals('nohup php bin/console console:command --env=dev', $clb->line());
	}
	
	public function test_It_creates_a_line_with_named_argument()
	{
		$clb = (new CommandLineBuilder('console:command'))->withNamedArgument('name', 'value');
		$this->assertEquals('nohup php bin/console console:command name:value', $clb->line());
	}
}

?>

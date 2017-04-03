<?php

namespace Tests\Infrastructure\Process;

use Milhojas\Infrastructure\Process\CommandLineBuilder;
use PHPUnit\Framework\TestCase;


/**
 * Description.
 */
class CommandLineBuilderTest extends Testcase
{

    public function test_It_creates_a_line_with_no_arguments()
    {
        $clb = new CommandLineBuilder('console:command');
        $this->assertEquals('php bin/console console:command', $clb->line());
    }

    public function test_It_creates_a_line_with_argument()
    {
        $clb = (new CommandLineBuilder('console:command'))->withArgument('argument');
        $this->assertEquals('php bin/console console:command argument', $clb->line());
    }

    public function test_It_creates_a_line_with_output()
    {
        $clb = (new CommandLineBuilder('console:command'))->outputTo('file.log');
        $this->assertEquals('php bin/console console:command > file.log', $clb->line());
    }

    public function test_It_creates_a_line_with_enviroment()
    {
        $clb = (new CommandLineBuilder('console:command'))->environment('dev');
        $this->assertEquals('php bin/console console:command --env=dev', $clb->line());
    }

    public function test_It_creates_a_line_with_named_argument()
    {
        $clb = (new CommandLineBuilder('console:command'))->withNamedArgument('name', 'value');
        $this->assertEquals('php bin/console console:command name:value', $clb->line());
    }

    public function test_It_accepts_working_dir()
    {
        $clb = (new CommandLineBuilder('console:command'))->setWorkingDirectory('/root/dir');
        $this->assertEquals('php bin/console console:command', $clb->line());
    }

    public function test_it_can_be_constructed_with_arguments_and_add_command_afterwards()
    {
        $clb = (new CommandLineBuilder())->setCommand('console:command');
        $this->assertEquals('php bin/console console:command', $clb->line());
    }


    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_it_should_not_allow_generation_if_lacks_command()
    {
        $clb = (new CommandLineBuilder());
        $clb->line();
    }

    public function test_it_can_change_template()
    {
        $clb = (new CommandLineBuilder())->setCommand('console:command')->setTemplate('php %s');
        $this->assertEquals('php console:command', $clb->line());
    }


}

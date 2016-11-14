<?php

namespace Milhojas\Infrastructure\Process;

use Milhojas\Infrastructure\Process\CommandLine;
use Milhojas\Infrastructure\Process\CommandLineProcess;
/**
* Builds command lines to execute with Process component
*/
class CommandLineBuilder
{
	private $command;
	private $arguments;
	private $environment;
	private $workingDir;
	private $output;
	
	public function __construct($command)
	{
		$this->command = $command;
		$this->arguments = [];
		$this->output = '';
		return $this;
	}	
	
	public function withArgument($argument)
	{
		$this->arguments[] = trim($argument);
		return $this;
	}
	
	public function withNamedArgument($name, $argument)
	{
		$this->arguments[] = trim(sprintf('%s:%s', $name, $argument));
		return $this;
	}
	
	public function outputTo($output)
	{
		$this->output = $output;
		return $this;
	}
	
	public function environment($env)
	{
		$this->environment = $env;
		return $this;
	}
	
	public function line()
	{
		$template = 'nohup php bin/console %s';
		$line = sprintf($template, $this->command);
		$line .= $this->buildArguments();
		$line .= $this->buildEnvironment();
		$line .= $this->buildOutputTo();
		return trim($line);
	}
	
	private function buildArguments()
	{
		if (!$this->arguments) {
			return false;
		}
		return ' '.implode(' ', $this->arguments);
	}
	
	private function buildEnvironment()
	{
		if (!$this->environment) {
			return false;
		}
		return ' --env='.$this->environment;
	}
	
	public function buildOutputTo()
	{
		if (!$this->output) {
			return false;
		}
		return sprintf(' > %s', $this->output);
	}
	
	public function setWorkingDirectory ($workingDir)
	{
		$this->workingDir = $workingDir;
		return $this;
	}
	
	public function setProcess(CommandLine $process = null)
	{
		$this->process = $process ? $process : new CommandLineProcess($this->line());
		return $this;
	}
	
	public function start()
	{
		if (file_exists($this->output)) {
			unlink($this->output);
		}
		$this->setProcess();
		$this->process->setWorkingDirectory($this->workingDir);
		$this->process->start(function ($type, $buffer) {
		    if ('err' === $type) {
		        echo 'ERR > '.$buffer;
		    } else {
		        echo 'OUT > '.$buffer;
		    }
		});
		return $this;
	}

}

?>
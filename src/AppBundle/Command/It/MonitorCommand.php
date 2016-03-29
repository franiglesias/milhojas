<?php

namespace AppBundle\Command\It;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;


use Milhojas\Library\System\Ping;
/**
* Description
*/
class MonitorCommand extends Command
{
	private $bus;
	
	function __construct($bus)
	{
		$this->bus = $bus;
		parent::__construct();
	}
	
    protected function configure()
    {
        $this
            ->setName('it:monitor')
            ->setDescription('Checks devices status.')
        ;
    }
	
    protected function execute(InputInterface $input, OutputInterface $output)
    {
		$output->writeln('Starting monitor');
	}
	

}

?>
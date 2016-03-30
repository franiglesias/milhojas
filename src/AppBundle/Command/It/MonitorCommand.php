<?php

namespace AppBundle\Command\It;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;


use Milhojas\Library\System\Ping;

use Milhojas\Domain\It\DeviceIdentity;
use Milhojas\Infrastructure\Network\WebDeviceStatus;
use Milhojas\Infrastructure\Network\Printers\PrinterConfiguration;
use Milhojas\Infrastructure\Network\Printers\DSM745PrinterDriver;

use Milhojas\Library\ValueObjects\Technical\Ip;
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
		$command = new \Milhojas\Application\It\MonitorDevices([
			new \Milhojas\Infrastructure\Network\Printer(
				new DeviceIdentity('Impresora ESO', 'Sala ESO'),
				new WebDeviceStatus(new Ip('172.16.0.224'), DSM745PrinterDriver::URL),
				new DSM745PrinterDriver(),
				new PrinterConfiguration(4, ['K'])
			),
				
			// new Milhojas\Infrastructure\Network\Printer()
		]);
		$this->bus->execute($command);
	}
	

}

?>
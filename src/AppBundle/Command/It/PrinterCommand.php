<?php

namespace AppBundle\Command\It;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;

use Symfony\Component\DomCrawler\Crawler;

use Milhojas\Library\System\Ping;
/**
* Description
*/
class PrinterCommand extends Command
{
	private $url;
	
	function __construct()
	{
		$this->url = 'http://172.16.0.222/web/guest/es/websys/webArch/topPage.cgi';
		parent::__construct();
	}
	
    protected function configure()
    {
        $this
            ->setName('it:printer')
            ->setDescription('Checks printer status.')
        ;
    }
	
    protected function execute(InputInterface $input, OutputInterface $output)
    {
		// $page = file_get_contents($this->url);
		// $this->extractTrayInfo($page, 1);
		if(Ping::isListening('miralba.org')) {
			$output->writeln('Server is up');
		}
	}
	
	private function extractTrayInfo($page, $tray = 1)
	{
		$crawler = new Crawler($page);
		$crawler = $crawler->filter('tr.staticProp td');
		print_r($crawler);
	}
}

?>
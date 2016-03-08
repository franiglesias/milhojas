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
		if(Ping::isListening('miralba.org')) {
			$output->writeln('Server is up');
		}
		$page = file_get_contents($this->url);
		if ($this->extractSAT($page)) {
			$output->writeln('Printer needs SAT.');
		}
		for ($i=0; $i <= 4; $i++) { 
			$output->writeln('Tray '.($i+1).': '.$this->extractTrayInfo($page, $i));
		}
		$messages = array(0 => 'Reemplazar', 1 => 'Bajo', 2=> 'Medio bajo', 3 =>'Medio', 4 => 'Alto', 5 => 'Lleno'); 
		foreach (array('K' => 'Negro', 'M' => 'Magenta', 'C' => 'Cyan', 'Y' => 'Amarillo') as $color => $name) {
			$result = $this->extractTonerInfo($page, $color);
			$output->writeln('Color: '.$name.': '.$messages[$result]);
		}
	}
	
	private function extractSAT($page)
	{
		return preg_match('/\/images\/deviceStScall16.gif/', $page, $matches) > 0;
	}
	
	private function extractTrayInfo($page, $tray)
	{
		preg_match_all('/deviceStP(.+?)_?16\.gif/', $page, $matches);
		return $matches[1][$tray];
	}
	
	public function extractTonerInfo($page, $color)
	{
		preg_match_all('/deviceStToner('.$color.')\.gif/', $page, $matches);
		return count($matches[1]);
	}
}

?>
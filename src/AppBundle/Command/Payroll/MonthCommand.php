<?php

namespace AppBundle\Command\Payroll;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;

use Symfony\Component\Finder\Finder;

use AppBundle\Command\Payroll\Utils\Ping;

class MonthCommand extends Command
{
	private $emails;
	private $month;
	private $sender;
	private $dataPath;
	private $bus;

	## members
	private $mailer;
	
	public function __construct($mailer, $sender, $bus, $dataPath)
	{
		$this->mailer = $mailer;
		$this->sender = $sender;
		$this->bus = $bus;
		$this->dataPath = $dataPath;


		parent::__construct();
	}
	
    protected function configure()
    {
        $this
            ->setName('payroll:month')
            ->setDescription('Sends payroll PDFs via email.')
            ->addArgument(
                'month',
                InputArgument::OPTIONAL,
                'What month is this payroll?'
            )
        ;
    }
	
	
    protected function execute(InputInterface $input, OutputInterface $output)
    {
		$this->checkServer();
		$output->writeln('Mail server is Up.');

		$command = new \Milhojas\Application\Management\SendPayroll($this->sender, $input->getArgument('month'));
		// $bus = new \Milhojas\Library\CommandBus\BasicCommandBus(array(
		// 	new \Milhojas\Library\CommandBus\Workers\ExecuteWorker($this->get('handler_container'), $this->get('handler_inflector'))
		// ));
		$this->bus->execute($command);
    }
		
	
	public function checkServer()
	{
		if (!Ping::check('smtp.gmail.com')) {
			throw new \RuntimeException('Mail Server unavailable. Check Internet connectivity.', 1);
		}
	}
}
?>
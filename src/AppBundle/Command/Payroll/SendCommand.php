<?php

namespace AppBundle\Command\Payroll;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;

use Symfony\Component\Finder\Finder;


use AppBundle\Command\Payroll\Model\Payroll;
use AppBundle\Command\Payroll\Model\PayrollRepository;
use AppBundle\Command\Payroll\Reporter\PayrollReporter;
use AppBundle\Command\Payroll\Reporter\ConsoleReporter;
use AppBundle\Command\Payroll\Reporter\EmailReporter;

use AppBundle\Command\Payroll\Utils\Ping;

class SendCommand extends Command
{
	private $emails;
	private $month;
	private $sender;
	private $dataPath;
	private $report;

	## members
	private $mailer;
	private $reporter;
	
	public function __construct($mailer, $sender, $report, $dataPath)
	{
		$this->mailer = $mailer;
		$this->sender = $sender;
		$this->report = $report;
		$this->dataPath = $dataPath;


		parent::__construct();
	}
	
    protected function configure()
    {
        $this
            ->setName('payroll:send')
            ->setDescription('Sends payroll PDFs via email.')
            ->addArgument(
                'month',
                InputArgument::OPTIONAL,
                'What month is this payroll?'
            )
        ;
    }
	
	private function buildReporter($output)
	{
		$this->reporter =  new EmailReporter(
			new ConsoleReporter(
				new PayrollReporter(),
				$output
			),
			$this->mailer,
			$this->report
		);
	}
	
    protected function execute(InputInterface $input, OutputInterface $output)
    {
		$this->checkServer();
		$this->buildReporter($output);
		
		$output->writeln('Mail server is Up.');
		
		$this->month = $input->getArgument('month');
		
		$finder = new Finder();
		$finder->files()->in($this->dataPath.'/'.$this->month);
		
		$repository = new PayrollRepository($this->dataPath);
		
		
		$this->reporter->setTotal(count($finder));
		$progress = new ProgressBar($output, count($finder));
		$progress->start();

		foreach ($finder as $file) {
			$payroll = $repository->get($file);
			if (!$this->sendEmail($payroll)) {
				$this->reporter->error('Problem with email: '.$payroll->getEmail());
			} else {
				$this->reporter->add(sprintf('Email sent to %s.',$payroll->getName()));
				$this->reporter->add('Deleting associated file.');	
			    unlink($payroll->getFile());
			}
			$progress->advance();
		}

		$progress->finish();
		$this->reporter->report();
    }
		
	private function sendEmail($payroll)
	{
		$message = \Swift_Message::newInstance()
			->setSubject(sprintf('Nómina de %s', $this->month))
			->setFrom($this->sender)
			->setReturnPath(key($this->sender))
			->setReplyTo(key($this->sender))
			->setSender(key($this->sender))
			->setTo($payroll->getTo())
			->setBody(sprintf('Estimado/a %s:'.chr(10).chr(10).'Adjuntamos tu nómina del mes de %s', $payroll->getName(), $this->month))
			->addPart(sprintf('<p>Estimado/a %s:</p><p>Adjuntamos tu nómina del mes de %s</p>', $payroll->getName(), $this->month), 'text/html')
			->attach(\Swift_Attachment::fromPath($payroll->getFile()));
		
		return $this->mailer->send($message);
	}
	
	public function checkServer()
	{
		if (!Ping::check('smtp.gmail.com')) {
			throw new \RuntimeException('Mail Server unavailable. Check Internet connectivity.', 1);
		}
	}
}
?>
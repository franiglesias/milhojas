<?php

namespace AppBundle\Command\Payroll;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Milhojas\Library\System\Ping;

use Milhojas\Application\Management\EmailPayroll;
use Milhojas\Infrastructure\Persistence\Management\PayrollFile;
use Milhojas\Domain\Management\PayrollRepository;

use Milhojas\Library\ValueObjects\Misc\Progress;
use Milhojas\Library\CommandBus\Commands\BroadcastEvent;
use Milhojas\Domain\Management\Events\AllPayrollsWereSent;

class SendCommand extends Command
{
	private $sender;
	private $bus;
	private $repository;
	
	public function __construct($bus, $sender, PayrollRepository $repository)
	{
		$this->sender = $sender;
		$this->bus = $bus;
		$this->repository = $repository;
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
	
    protected function execute(InputInterface $input, OutputInterface $output)
    {
		$output->writeln( $this->checkServer() );
		
		$files = $this->repository->getFiles($input->getArgument('month'));
		$progress = new Progress(0, iterator_count($files));
		
		foreach ($files as $file) {
			$progress = $progress->advance();
			$payroll = $this->repository->get(new PayrollFile($file));
			$command = new EmailPayroll($payroll, $this->sender, $input->getArgument('month'), $progress);
			$this->bus->execute($command);
		}
		
		$this->bus->execute(new BroadcastEvent(new AllPayrollsWereSent($progress, $input->getArgument('month'))));
		$output->writeln('Task end.');
    }
		
	public function checkServer()
	{
		if (!Ping::check('smtp.gmail.com')) {
			throw new \RuntimeException('Mail Server unavailable. Check Internet connectivity.', 1);
		}
		return 'Mail Server is Up.';
	}
}
?>
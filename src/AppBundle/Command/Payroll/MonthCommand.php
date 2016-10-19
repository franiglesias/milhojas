<?php

namespace AppBundle\Command\Payroll;

# Domain concepts

use Milhojas\Domain\Management\Staff;
use Milhojas\Domain\Management\PayrollReporter;

# Commands

use Milhojas\Application\Management\Commands\SendPayroll;
use Milhojas\Library\CommandBus\Commands\BroadcastEvent;

# Events

use Milhojas\Domain\Management\Events\AllPayrollsWereSent;

# Utils

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Milhojas\Library\System\Ping;

/**
 * Console command to send payrolls pdf to staff
 *
 * @package default
 * @author Francisco Iglesias Gómez
 */
class MonthCommand extends Command
{
	private $sender;
	private $bus;
	private $staff;
	
	public function __construct($bus, $sender, Staff $staff)
	{
		$this->sender = $sender;
		$this->bus = $bus;
		$this->staff = $staff;
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
		$output->writeln( $this->checkServer() );
		
		$progress = new PayrollReporter(0, $this->staff->countAll());
		
		foreach ($this->staff as $employee) {
			$progress = $progress->advance();
			$command = new SendPayroll($employee, $this->sender, $input->getArgument('month'), $progress);
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

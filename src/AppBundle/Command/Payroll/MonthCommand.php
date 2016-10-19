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
use Symfony\Component\Console\Style\SymfonyStyle;

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
		$io = new SymfonyStyle($input, $output);
		$io->title('Payroll sending for '.$input->getArgument('month'));
		$io->section('Checking server');
		$io->success($this->checkServer());
		$io->section('Processing Employee list');
		try {
			$progress = new PayrollReporter(0, $this->staff->countAll());
			foreach ($this->staff as $employee) {
				$progress = $progress->advance();
				$command = new SendPayroll($employee, $this->sender, $input->getArgument('month'), $progress);
				$this->bus->execute($command);
			}
			$this->bus->execute(new BroadcastEvent(new AllPayrollsWereSent($progress, $input->getArgument('month'))));
			$io->success('Task ended.');
		} catch (\Milhojas\Infrastructure\Persistence\Management\Exceptions\PayrollRepositoryDoesNotExist $e) {
			$io->warning(array(
				sprintf($e->getMessage() ),
				'Please, review config/services/management.yml parameter: payroll.dataPath',
				'Use a path to a valid folder containing payroll files or payroll zip archives.'
			));
		} catch (\Milhojas\Infrastructure\Persistence\Management\Exceptions\PayrollRepositoryForMonthDoesNotExist $e) {
			$io->error(array(
				sprintf($e->getMessage() ),
				'Please, add the needed folder or zip archives for month data.',
				'Use a path to a valid folder containing payroll files.'
			));
		}
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

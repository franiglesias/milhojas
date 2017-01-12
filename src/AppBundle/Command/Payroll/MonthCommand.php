<?php

namespace AppBundle\Command\Payroll;

use Milhojas\Domain\Management\PayrollMonth;

# Commands

use Milhojas\Application\Management\Command\DistributePayroll;

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
	private $bus;
	
	public function __construct($bus)
	{
		$this->bus = $bus;
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
			->addArgument(
				'year',
				InputArgument::OPTIONAL,
				'What year?'
			)
			->addArgument(
				'paths',
				InputArgument::IS_ARRAY,
				'Locations of payroll files'
			)
		;
	}
	
    protected function execute(InputInterface $input, OutputInterface $output)
    {
		$io = new SymfonyStyle($input, $output);
		$io->title('Payroll sending for '.$input->getArgument('month'));
		try {
			$io->section('Checking server');
			$io->success($this->checkServer());
			$io->section('Processing Employee list');
			$this->bus->execute( new DistributePayroll(new PayrollMonth($input->getArgument('month'), $input->getArgument('year')), $input->getArgument('paths')) );
			$io->success('Task ended.');
		} catch (\Milhojas\Infrastructure\Persistence\Management\Exceptions\PayrollRepositoryDoesNotExist $e) {
			$io->warning(array(
				sprintf($e->getMessage() ),
				'Please, review config/services/management.yml parameter: payroll.dataPath',
				'Use a path to a valid folder containing payroll files or payroll zip archives.'
			));
		} catch (\Milhojas\Infrastructure\Persistence\Management\Exceptions\PayrollRepositoryForMonthDoesNotExist $e) {
			$io->warning(array(
				$e->getMessage(),
				'Please, add the needed folder or zip archives for month data.',
				'Use a path to a valid folder containing payroll files.'
			));
		} catch (\RuntimeException $e) {
			$io->error(array(
				$e->getMessage(),
				'Check Internet connectivity and try again later.'
				)
			);
		}
    }
		
	protected function checkServer()
	{
		if (!Ping::check('smtp.gmail.com')) {
			throw new \RuntimeException('Mail Server unavailable.', 1);
		}
		return 'Mail Server is Up and accepts connections.';
	}
}
?>

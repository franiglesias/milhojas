<?php

namespace AppBundle\Command\Payroll;

use Symfony\Component\Console\Command\Command;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Console\Helper\ProgressBar;


/**
 * Represents a Payroll file
 *
 * @package default
 * @author Francisco Iglesias Gómez
 */
class Payroll {
	private $file;
	private $id;
	private $name;
	private $path;
	private $email;
	
	public function __construct($file)
	{
		$this->file = $file;
		$this->name = $this->extractNameFromFileName();
		$this->id = $this->extractIdFromFileName();
		$this->path = $this->file->getRealpath();
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function getFile()
	{
		return $this->path;
	}
	
	public function setEmail($email)
	{
		$this->email = $email;
	}
	
	public function getEmail()
	{
		return $this->email;
	}
	
	public function getTo()
	{
		return array($this->email => $this->name);
	}
	
	private function extractNameFromFileName()
	{
		$filename = $this->file->getRelativePathname();
		preg_match('/nombre_\((.*), (.*)\)/', $filename, $matches);
		return mb_convert_case($matches[2].' '.$matches[1], MB_CASE_TITLE);
	}
	
	private function extractIdFromFileName()
	{
		$filename = $this->file->getRelativePathname();
		preg_match('/trabajador_(\d+_\d+)/',$filename, $matches);
		return $matches[1];
	}
}


/**
 * Repository for the email list
 *
 * @package default
 * @author Francisco Iglesias Gómez
 */
class PayrollRepository {
	private $emails;
	
	public function __construct($path)
	{
		$this->emails = $this->load($path.'/emails.dat');
	}
	
	public function get($file)
	{
		$Payroll = new Payroll($file);
		$Payroll->setEmail($this->emails[$Payroll->getId()]);
		return $Payroll;
	}
	
	private function load($path)
	{
		$emails = array();
		foreach (file($path) as $line) {
			list($id, $email) = explode(chr(9), $line);
			$emails[$id] = trim($email);
		}
		return $emails;
	}
	
}


/**
* Description
*/
class PayrollReporter
{
	private $lines;
	private $total;
	private $errors;
	
	
	function __construct($total)
	{
		$this->lines = array();
		$this->errors = array();
		$this->total = $total;
	}
	
	public function add($line)
	{
		$this->lines[] = $line;
	}
	
	public function report()
	{
		array_unshift($this->lines, sprintf('%s of %s messages sent.', $this->total - count($this->errors), $this->total));
		$this->lines += $this->errors;
		return $this->lines;
	}
	
	public function error($line)
	{
		$this->errors[] = 'ERROR: '.$line;
	}
}

abstract class ReporterDecorator
{
	
	protected $reporter;
	
	function __construct($reporter)
	{
		$this->reporter = $reporter;
	}
	
	public function add($line)
	{
		$this->reporter->add($line);
	}
	
	abstract public function report();

	public function count()
	{
		$this->reporter->count();
	}
}

/**
* Description
*/
class ConsoleReporter extends ReporterDecorator
{
	private $output;
	
	function __construct($reporter, $output)
	{
		parent::__construct($reporter);
		$this->output = $output;
	}
	
	public function report()
	{
		$lines = $this->reporter->report();
		$this->output->writeln(chr(10));
		foreach ($lines as $line) {
			$this->output->writeln($line);
		}
		return $lines;
	}
}

/**
* Description
*/
class EmailReporter extends ReporterDecorator
{
	private $mailer;
	private $to;
	
	function __construct($reporter, $mailer, $to)
	{
		parent::__construct($reporter);
		$this->mailer = $mailer;
		$this->to = $to;
	}
	
	public function report()
	{
		$lines = $this->reporter->report();
		$message = implode(chr(10), $lines);
		$this->send($message);
		return $lines;
	}
	
	private function send($body)
	{
		// Create the message
		$message = \Swift_Message::newInstance()

			// Give the message a subject
			->setSubject(sprintf('Envío de Nóminas'))

			// Set the From address with an associative array
			// ->setFrom($sender)
			// ->setReturnPath('administracion@miralba.org')
			// ->setReplyTo('administracion@miralba.org')
			// 	->setSender('administracion@miralba.org')

			// Set the To addresses with an associative array
			->setTo($this->to)

			// Give it a body
			->setBody($body);

		
		return $this->mailer->send($message);

	}
}


class SendCommand extends Command
{
	private $emails;
	private $month;
	private $sender;
	private $dataPath;
	private $report;
	private $mailer;
	
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
	
    protected function execute(InputInterface $input, OutputInterface $output)
    {
		// $dataPath = __DIR__.'/../../../../payroll';
		// $dataPath = $this->dataPath;
		// $output->writeln($dataPath);
		$this->month = $input->getArgument('month');
		
		$finder = new Finder();
		$finder->files()->in($this->dataPath.'/'.$this->month);
		
		$repository = new PayrollRepository($this->dataPath);
		$reporter = new EmailReporter(
						new ConsoleReporter(
							new PayrollReporter(count($finder))
							, $output)
						, $this->mailer
						, $this->report
					);
		
		$progress = new ProgressBar($output, count($finder));
		$progress->start();

		foreach ($finder as $file) {
			$payroll = $repository->get($file);
			if (!$this->sendEmail($payroll)) {
				$reporter->error('Problem with email: '.$payroll->getEmail());
			}
			$progress->advance();
		}
		$progress->finish();
		
		$reporter->report();
    }
		
	private function sendEmail($payroll)
	{
		
		$sender = array('administracion@miralba.org' => 'Administración Colegio Miralba');
		// Create the message
		$message = \Swift_Message::newInstance()

			// Give the message a subject
			->setSubject(sprintf('Nómina de %s', $this->month))

			// Set the From address with an associative array
			->setFrom($this->sender)
			->setReturnPath('administracion@miralba.org')
			->setReplyTo('administracion@miralba.org')
				->setSender('administracion@miralba.org')

			// Set the To addresses with an associative array
			->setTo($payroll->getTo())

			// Give it a body
			->setBody(sprintf('Estimado/a %s:'.chr(10).chr(10).'Adjuntamos tu nómina del mes de %s', $payroll->getName(), $this->month))

			// And optionally an alternative body
			->addPart(sprintf('<p>Estimado/a %s:</p><p>Adjuntamos tu nómina del mes de %s</p>', $payroll->getName(), $this->month), 'text/html')

			// Optionally add any attachments
			->attach(\Swift_Attachment::fromPath($payroll->getFile()));
			
		return $this->mailer->send($message);
	}
}
?>
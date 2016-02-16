<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


use Symfony\Component\Finder\Finder;

class Payroll {
	private $file;
	private $email;
	private $name;
	private $path;
	
	public function __construct($file)
	{
		$this->file = $file;
	}
	
	public function getEmail()
	{
		# code...
	}
	
	public function getName()
	{
		# code...
	}
	
	public function getFile()
	{
		# code...
	}
}

class SendCommand extends ContainerAwareCommand
{
	private $emails;
	private $month;
	private $sender;
	private $dataPath;
	
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
		$dataPath = __DIR__.'/../../../payroll';
		$this->emails = $this->readEmails($dataPath.'/emails.dat', $output);
		$this->month = $input->getArgument('month');
		$finder = new Finder();
		
		$finder->files()->in($dataPath.'/'.$this->month);
		$count = 0;
		foreach ($finder as $file) {
			$email = $this->getEmailForFile($file);
			$name = $this->getNameForFile($file);
			$output->writeln('['.$count.'] Sending email to: '.$name);
			if (!$this->sendEmail(array($email => $name), $file->getRealpath())) {
				$output->writeln('Problem with email: '.$email);
			}
			$count = $count + 1;;
			if ($count > 1) {
				break;
			}
		}
    }
	
	private function readEmails($path)
	{
		$emails = array();
		foreach (file($path) as $line) {
			list($id, $email) = explode(chr(9), $line);
			$emails[$id] = $email;
		}
		return $emails;
	}
	
	private function extractIdFromFileName($filename)
	{
		preg_match('/trabajador_(\d+_\d+)/',$filename, $matches);
		return $matches[1];
	}
	
	private function extractNameFromFileName($filename)
	{
		preg_match('/nombre_\((.*), (.*)\)/', $filename, $matches);
		return mb_convert_case($matches[2].' '.$matches[1], MB_CASE_TITLE);
	}
	
	private function getEmail($id)
	{
		return trim($this->emails[$id]);
	}
	
	private function getEmailForFile($file)
	{
		$id = $this->extractIdFromFileName($file->getRelativePathname());
		return $this->getEmail($id);
	}
	
	public function getNameForFile($file)
	{
		return $this->extractNameFromFileName($file->getRelativePathname()); 
	}
	
	private function sendEmail($to, $file)
	{
		$sender = array('administracion@miralba.org' => 'Administración Colegio Miralba');
		// Create the message
		$message = \Swift_Message::newInstance()

			// Give the message a subject
			->setSubject(sprintf('Nómina de %s', $this->month))

			// Set the From address with an associative array
			->setFrom($sender)
			->setReturnPath('administracion@miralba.org')
			->setReplyTo('administracion@miralba.org')

			// Set the To addresses with an associative array
			->setTo($to)

			// Give it a body
			->setBody(sprintf('Estimado/a %s:'.chr(10).chr(10).'Adjuntamos tu nómina del mes de %s', current($to), $this->month))

			// And optionally an alternative body
			->addPart(sprintf('<p>Estimado/a %s:</p><p>Adjuntamos tu nómina del mes de %s</p>', current($to), $this->month), 'text/html')

			// Optionally add any attachments
			->attach(\Swift_Attachment::fromPath($file));
			
		return $this->getContainer()->get('mailer')->send($message);
	}
}
?>
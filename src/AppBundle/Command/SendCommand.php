<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


use Symfony\Component\Finder\Finder;

class SendCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('payroll:send')
            ->setDescription('Greet someone')
            ->addArgument(
                'name',
                InputArgument::OPTIONAL,
                'Who do you want to greet?'
            )
            ->addOption(
               'yell',
               null,
               InputOption::VALUE_NONE,
               'If set, the task will yell in uppercase letters'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
		$dataPath = __DIR__.'/../../../data';
		$emails = $this->readEmails($dataPath.'/emails.dat', $output);
		$finder = new Finder();
		
		$finder->files()->in($dataPath.'/nominas');
		foreach ($finder as $file) {
		    // Dump the absolute path
		    // var_dump($file->getRealpath());

		    // Dump the relative path to the file, omitting the filename
		    // var_dump($file->getRelativePath());

		    // Dump the relative path to the file
			
			$id = $this->extractIdFromFileName($file->getRelativePathname());
			$output->writeln($id);
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
		$id = $filename;
		return $id;
	}
}
?>
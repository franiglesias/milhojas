<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

use Milhojas\Infrastructure\Process\CommandLineBuilder;

use Milhojas\Application\Management\Form\Type\PayrollType;
use Milhojas\Application\Management\PayrollDistributor;

class ManagementController extends Controller
{
    /**
     * @Route("/management", name="management-home")
     * @Method({"GET","HEAD"})
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle:Default:index.html.twig');
    }
	
	
	/**
	 * @Route("/management/payroll/upload", name="payroll-upload")
	 * @Method({"GET", "POST"})
	 * @param Request $request 
	 * @return void
	 * @author Fran Iglesias
	 */
    public function uploadAction(Request $request)
    {
        $payrollDist = new PayrollDistributor();
        $payrollDist->setMonth('septiembre');
		$payrollDist->setYear('2016');
        $form = $this->createForm(PayrollType::class, $payrollDist);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$payrollDist = $form->getData();
			foreach ($payrollDist->getFile() as $file) {
				$fileName = $this->get('milhojas.uploader')->upload($file);
				$payrollDist->setFileName($fileName);
			}
			$this->launchCommand($payrollDist);
			return $this->redirectToRoute('payroll-results');
	    }

        return $this->render('AppBundle:Management:web/payroll-upload-form.html.twig', array(
            'form' => $form->createView(),
        ));
		
    }
	/**
	 * @Route("/management/payroll/results", name="payroll-results")
	 * @Method({"GET"})
	 * @param Request $request 
	 * @return void
	 * @author Fran Iglesias
	 */
	public function resultsAction()
	{
		return $this->render('AppBundle:Management:web/payroll-upload-result.html.twig');
	}
	
	
	private function launchCommand($payrollDist)
	{
		(new CommandLineBuilder('payroll:month'))
			->withArgument( $payrollDist->getMonth() )
			->withArgument( $payrollDist->getYear() )
			->withArgument( implode(' ', $payrollDist->getFileName()) )
			->outputTo('var/logs/payroll-month-output.log')
			->environment( $this->get('kernel')->getEnvironment() )
			->setWorkingDirectory( $this->get('kernel')->getRootDir().'/../' )
			->start();
		;
	}
	
}

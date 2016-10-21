<?php

namespace AppBundle\Controller;


use Milhojas\Application\Management\PayrollDistributor;



use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


use Milhojas\Application\Management\Form\PayrollType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Method({"GET","HEAD"})
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle:Default:index.html.twig');
    }
	
	
	/**
	 * @Route("/welcome", name="welcome")
	 * @Security("has_role('ROLE_USER')")
	 * @Method({"GET","HEAD"})
	 * @return void
	 * @author Fran Iglesias
	 */
	public function welcomeAction(Request $request)
	{
		return $this->render('default/welcome.html.twig');
	}
	
	/**
	 * @Route("/hello/{name}.{_format}", defaults={"_format"="html"}, name="hello")
	 * @Method({"GET","HEAD"})
	 * @Security("has_role('ROLE_OAUTH_USER')")
	 * @param string $name 
	 * @return void
	 * @author Fran Iglesias
	 */
	public function helloAction($name, $_format, Request $request)
	{
		$session = $request->getSession();
		$session->set('name', $name);
		return $this->render('default/hello.'.$_format.'.twig', array(
			'name' => $name,
			'language' => $request->getPreferredLanguage()
		));
	}
	
	/**
	 * @Route("/upload", name="upload")
	 * @Method({"POST"})
	 * @param Request $request 
	 * @return void
	 * @author Fran Iglesias
	 */
    public function uploadAction(Request $request)
    {
        $payrollDist = new PayrollDistributor();
        $payrollDist->setMonth('septiembre');
        $payrollDist->setCompleted(new \DateTime('today'));
        $form = $this->createForm(PayrollType::class, $payrollDist);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
	        $payrollDist = $form->getData();
			$file = $payrollDist->getFile();
			$fileName = $this->get('milhojas.uploader')->upload($file);
			$payrollDist->setFile($fileName);
	        return $this->redirectToRoute('homepage');
	    }

        return $this->render('default/upload.html.twig', array(
            'form' => $form->createView(),
        ));
		
    }
	
	
}

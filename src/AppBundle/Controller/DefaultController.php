<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
	 * @Route("/exchange/{file}.{_format}", defaults={"_format"="json"}, name="exchange")
	 * @Method({"GET"})
	 *
	 * @param string $file 
	 * @return void
	 * @author Fran Iglesias
	 */
	public function exchangeAction($file)
	{
		$file = $this->get('kernel')->getRootDir().'/../var/exchange/'.$file.'.json';
		$response = new BinaryFileResponse($file);
		$response->setTtl(0);
		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}
	

}

<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ]);
    }
	/**
	 * @Route("/welcome", name="welcome")
	 *
	 * @return void
	 * @author Fran Iglesias
	 */
	public function welcomeAction(Request $request)
	{
		$session = $request->getSession();
		
		return new Response('Welcome to Symfony 3, '.$session->get('name'));
	}
	
	/**
	 * @Route("/hello/{name}.{_format}", defaults={"_format"="html"}, name="hello")
	 *
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
	 * @Route("/update/{id}")
	 */
	public function updateAction($id)
	{
		$command = new \Milhojas\Application\Contents\UpdatePost($id, 'New Title of a Post', 'New Body of the Post '.$id);
		$bus = new \Milhojas\Library\CommandBus\BasicCommandBus(array(
			new \Milhojas\Library\CommandBus\Workers\ExecuteWorker(
				$this->get('handler_container'), 
				$this->get('handler_inflector')
			),
			new \Milhojas\Library\CommandBus\Workers\DispatchEventsWorker(
				$this->get('event_bus'),
				$this->get('event_recorder')
			)
		));
		$bus->execute($command);
		return new Response('Update job done!');
	}
	
	/**
	 * @Route("/create/{id}")
	 */
	public function createAction($id)
	{
		$command = new \Milhojas\Application\Contents\WritePost($id, 'Post number '.$id, 'The body for this post');
		$bus = new \Milhojas\Library\CommandBus\BasicCommandBus(array(
			new \Milhojas\Library\CommandBus\Workers\ExecuteWorker(
				$this->get('handler_container'), 
				$this->get('handler_inflector')
			),
			new \Milhojas\Library\CommandBus\Workers\DispatchEventsWorker(
				$this->get('event_bus'),
				$this->get('event_recorder')
			)
		));
		$bus->execute($command);
		return new Response('Create post done!');
	}
	
}

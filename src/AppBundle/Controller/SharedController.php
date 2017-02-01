<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Milhojas\Infrastructure\Ui\Shared\Form\Type\StudentType;
use Milhojas\Application\Shared\Command\EnrollStudent;
use Milhojas\Library\ValueObjects\Identity\Person;

class SharedController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Method({"GET","HEAD"})
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:Default:index.html.twig');
    }

    /**
     * @Route("/shared/student/enroll", name="new-student-enroll")
     * @Method({"GET","POST"})
     */
    public function enrollAction(Request $request)
    {
        $form = $this->createForm(StudentType::class, new EnrollStudent(new Person('', '', '')));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bus = $this->get('command_bus');
            $bus->execute($form->getData());

            return $this->render('AppBundle:Shared:web/student-enrolled.html.twig', array(
                'student' => $form->getData(),
            ));
        }

        return $this->render('AppBundle:Shared:web/student-enroll-form.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}

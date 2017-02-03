<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Milhojas\Infrastructure\Ui\Shared\Form\Type\StudentType;
use Milhojas\Infrastructure\Ui\Shared\Form\Data\StudentData;
use Milhojas\Application\Shared\Command\EnrollStudent;
use Milhojas\Application\Shared\Query\GetAllEnrolledStudents;

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
        $form = $this->createForm(StudentType::class, new StudentData());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bus = $this->get('command_bus');
            $bus->execute(EnrollStudent::fromStudentForm($form->getData()));

            return $this->redirect($this->generateUrl('student-enrolled'));
        }

        return $this->render('AppBundle:Shared:web/student-enroll-form.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/shared/student/enrolled", name="student-enrolled")
     * @Method({"GET"})
     */
    public function enrolledAction()
    {
        $bus = $this->get('query_bus');
        $enrolled = $bus->execute(new GetAllEnrolledStudents());

        return $this->render('AppBundle:Shared:web/student-enrolled.html.twig', array(
            'students' => $enrolled,
        ));
    }
}

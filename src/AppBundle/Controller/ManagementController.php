<?php

namespace AppBundle\Controller;

use Milhojas\Application\Management\Command\LaunchPayrollDistributor;
use Milhojas\Application\Management\PayrollDistributionEnvironment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Milhojas\Infrastructure\Ui\Management\Form\Type\PayrollType;
use Milhojas\Application\Management\PayrollDistributor;
use Milhojas\Domain\Management\PayrollMonth;


class ManagementController extends Controller
{
    /**
     * @Route("/management", name="management-home")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"GET","HEAD"})
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:Default:index.html.twig');
    }

    /**
     * @Route("/management/payroll/upload", name="payroll-upload")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @param Request $request
     *
     * @author Fran Iglesias
     */
    public function uploadAction(Request $request)
    {
        $form = $this->createForm(PayrollType::class, new PayrollDistributor(PayrollMonth::current()));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $distribution = $form->getData();
            $distribution->uploadFiles($this->get('milhojas.uploader'));

            $command = new LaunchPayrollDistributor(
                $distribution,
                PayrollDistributionEnvironment::fromSymfonyKernel(
                    $this->get('kernel'),
                    'payroll-month-output.log'
                )
            );
            $this->get('command_bus')->execute($command);

            return $this->redirectToRoute('payroll-results');
        }

        return $this->render(
            'AppBundle:Management:web/payroll-upload-form.html.twig', [ 'form' => $form->createView() ] );
    }

    /**
     * @Route("/management/payroll/results", name="payroll-results")
     * @Method({"GET"})
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @author Fran Iglesias
     */
    public function resultsAction()
    {
        return $this->render('AppBundle:Management:web/payroll-upload-result.html.twig');
    }


}

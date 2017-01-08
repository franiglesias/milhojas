<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class CantineController extends Controller
{
    /**
     * @Route("/cantine/attendances", name="attendances")
     * @Method({"GET","HEAD"})
     */
    public function attendancesAction(Request $request)
    {
        $cantineList = (
            new CantineListRecord()

        );

        return $this->render('AppBundle:Cantine:attendances.html.twig', array(
            'cantineList' => $cantineList,
        ));
    }
}

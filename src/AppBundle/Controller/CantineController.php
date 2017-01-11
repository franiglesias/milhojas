<?php

namespace AppBundle\Controller;

use Milhojas\Application\Cantine\Query\GetCantineAttendancesListFor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CantineController extends Controller
{
    /**
     * @Route("/cantine/attendances/{date}", name="attendances")
     * @Method({"GET","HEAD"})
     * @ParamConverter("date", options={"format": "Y-m-d"})
     */
    public function attendancesAction(\DateTime $date)
    {
        $querybus = $this->get('query_bus');
        $attendances = $querybus->execute(new GetCantineAttendancesListFor($date));

        return $this->render('AppBundle:Cantine:attendances.html.twig', array(
            'date' => $date,
            'attendances' => $attendances,
        ));
    }
}

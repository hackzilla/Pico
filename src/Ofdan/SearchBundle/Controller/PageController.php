<?php

namespace Ofdan\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class PageController extends Controller
{
    public function searchboxAction()
    {
        $request = $this->get('request');
        $query = $request->request->get('q');

        return $this->render('OfdanSearchBundle:Page:searchbox.html.twig', array(
            'query' => $query,
        ));
    }
    
    public function spyAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('OfdanSearchBundle:LogSearch')
        ;

        $query = $repository->createQueryBuilder('ls')
            ->setMaxResults(20)
            ->orderBy('ls.createdAt', 'DESC')
            ->getQuery()
        ;

        return $this->render('OfdanSearchBundle:Page:spy.html.twig', array(
            'searches' => $query->getResult(),
        ));
    }
}

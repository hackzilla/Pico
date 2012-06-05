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
    
    public function statisticsAction()
    {
        
        return $this->render('OfdanSearchBundle:Page:statistics.html.twig', array(
            'average_seek' => 0,
            'total_queries' => 0,
            'total_queries_by_day' => 0,
            'known_lang' => 0,
            'known_words' => 0,
            'min_word_length' => 0,
            'avg_word_length' => 0,
            'max_word_length' => 0,
            'known_domains' => 0,
            'cached_domains' => 0,
            'stored_robots' => 0,
            'blocked_domains' => 0,
            'queued_domains' => 0,
            'require_update_domains' => 0,
            'disk_storage' => 0,
            'processor_load' => 0,
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

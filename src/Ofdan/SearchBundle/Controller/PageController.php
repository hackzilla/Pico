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
            'disk_storage' => $this->freeDiskSpace(),
            'processor_load' => $this->processorLoad(),
        ));
    }
    
    public function spyAction()
    {
        $em = $this->getDoctrine()
                   ->getEntityManager();

        $searches = $em->getRepository('OfdanSearchBundle:LogSearch')
                    ->getLatestSearches(20);

        return $this->render('OfdanSearchBundle:Page:spy.html.twig', array(
            'searches' => $searches,
        ));
    }
    
    /* Helper Functions */
    private function processorLoad()
    {
        $load = sys_getloadavg();
        
        return $load[0];
    }

    private function freeDiskSpace()
    {
        return disk_free_space("/");
    }
}

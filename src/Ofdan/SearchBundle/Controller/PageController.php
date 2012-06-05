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
        
        $em = $this->getDoctrine()
                   ->getEntityManager();

        $total_queries = $em->getRepository('OfdanSearchBundle:LogSearch')
            ->getTotalSearches();

        $total_queries_last_24hr = $em->getRepository('OfdanSearchBundle:LogSearch')
            ->getTotalSearches24Hr();

        $avg_seek_time_last_24hr = $em->getRepository('OfdanSearchBundle:LogSearch')
            ->getSeekTimeSearches24Hr();
        $data = array(
            'average_seek' => $avg_seek_time_last_24hr,
            'total_queries' => $total_queries,
            'total_queries_by_day' => $total_queries_last_24hr,
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
        );

        return $this->render('OfdanSearchBundle:Page:statistics.html.twig', $data);
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

<?php

namespace Ofdan\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ofdan\SearchBundle\Entity\Domain;

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

        $SeekandTotalSearches24Hr = $em->getRepository('OfdanSearchBundle:LogSearch')
            ->getSeekandTotalSearches24Hr();

        $DomainStatuses = $em->getRepository('OfdanSearchBundle:Domain')
            ->getDomainCountByStatus();
        
        $blockedDomains = 0;
        $knownDomains = 0;
        $queuedDomains = 0;

        foreach($DomainStatuses as $DomainStatus)
        {
            switch($DomainStatus['status'])
            {
                case Domain::STATUS_BLOCKED:
                    $blockedDomains = $DomainStatus['StatusCount'];
                    break;

                case Domain::STATUS_QUEUE:
                    $queuedDomains = $DomainStatus['StatusCount'];
                    break;

                case Domain::STATUS_STORED:
                    $knownDomains = $DomainStatus['StatusCount'];
                    break;
            }
        }
        
        $keywords = $em->getRepository('OfdanSearchBundle:Keyword')
            ->getKeywordLengths();

        $cached = $em->getRepository('OfdanSearchBundle:CacheIndex')
            ->getIndexCount();

        $robots = $em->getRepository('OfdanSearchBundle:CacheRobot')
            ->getRobotCount();

        $language = $em->getRepository('OfdanSearchBundle:Language')
            ->getKnownLanguages();

        $upToDateDomains = $em->getRepository('OfdanSearchBundle:Domain')
            ->getUpdatetoDateDomainCount();

        $data = array(
            'average_seek' => $SeekandTotalSearches24Hr['Seek'],
            'total_queries' => $total_queries,
            'total_queries_by_day' => $SeekandTotalSearches24Hr['SearchCount'],
            'known_languages' => $language['LanguageCount'],
            'known_domain_language' => 0,
            'known_words' => $keywords['KeywordCount'],
            'min_word_length' => $keywords['MinKeyword'],
            'avg_word_length' => $keywords['AvgKeyword'],
            'max_word_length' => $keywords['MaxKeyword'],
            'known_domains' => $knownDomains,
            'cached_domains' => $cached['IndexCount'],
            'stored_robots' => $robots['RobotCount'],
            'blocked_domains' => $blockedDomains,
            'queued_domains' => $queuedDomains,
            'require_update_domains' => ($upToDateDomains['UpToDateCount']/$knownDomains)*100,
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

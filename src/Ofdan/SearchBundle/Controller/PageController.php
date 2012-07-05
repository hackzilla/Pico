<?php

namespace Ofdan\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ofdan\SearchBundle\Entity\Domain;
use Ofdan\SearchBundle\Form\AddSiteType;

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
    
    public function suggestAction() {
        $entity = new \Ofdan\SearchBundle\Form\Model\AddSiteModel();
        $form = $this->createForm(new AddSiteType(), $entity);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $vars = $request->request->get($form->getName());

                // Perform some action, such as sending an email
                $em = $this->getDoctrine()
                            ->getEntityManager();

                $domainStatus = $em->getRepository('OfdanSearchBundle:Domain')
                    ->getDomainStatus($vars['domain']);

                if(NULL === $domainStatus) {
                    $domain = new Domain();
                    $domain->setDomain($vars['domain']);

                    $em->persist($domain);
                    $em->flush();

                    // Redirect - This is important to prevent users re-posting
                    // the form if they refresh the page
                    return $this->redirect($this->generateUrl('OfdanSearchBundle_suggestionAdded'));
                } else {
                    return $this->redirect($this->generateUrl('OfdanSearchBundle_suggestionExists'));
                }
            }
        }

        return $this->render('OfdanSearchBundle:Page:suggest.html.twig', array(
            'form' => $form->createView()
        ));        
    }

    public function suggestionAddedAction()
    {
        return $this->render('OfdanSearchBundle:Page:suggestAdded.html.twig', array(
        ));        
    }

    public function suggestionExistsAction()
    {
        return $this->render('OfdanSearchBundle:Page:suggestExists.html.twig', array(
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
        
        $KnownDomainLanguages = $em->getRepository('OfdanSearchBundle:Metadata')
            ->getDomainWithKnownLangCount();

        $data = array(
            'average_seek' => $SeekandTotalSearches24Hr['Seek'],
            'total_queries' => $total_queries,
            'total_queries_by_day' => $SeekandTotalSearches24Hr['SearchCount'],
            'known_languages' => $language['LanguageCount'],
            'known_domain_language' => ($KnownDomainLanguages / $knownDomains) * 100,
            'known_words' => $keywords['KeywordCount'],
            'min_word_length' => $keywords['MinKeyword'],
            'avg_word_length' => $keywords['AvgKeyword'],
            'max_word_length' => $keywords['MaxKeyword'],
            'known_domains' => $knownDomains,
            'cached_domains' => $cached['IndexCount'],
            'stored_robots' => $robots['RobotCount'],
            'blocked_domains' => $blockedDomains,
            'queued_domains' => $queuedDomains,
            'require_update_domains' => ($upToDateDomains/$knownDomains)*100,
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

    public function wordsAction($firstLetter = NULL, $secondLetter = NULL)
    {
        $request = $this->get('request');
        $firstLetter = $request->query->get('l');
        $secondLetter = $request->query->get('lb');

        if($secondLetter) {
            $em = $this->getDoctrine()
                    ->getEntityManager();

            $words = $em->getRepository('OfdanSearchBundle:Keyword')
                        ->getKeywordMatches($firstLetter[0].$secondLetter[0].'%');
        } else {
            $words = array();
        }
        
        return $this->render('OfdanSearchBundle:Page:words.html.twig', array(
            'letters' => range('A', 'Z'),
            'first_letter' => $firstLetter,
            'second_letter' => $secondLetter,
            'words' => $words,
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

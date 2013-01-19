<?php

namespace Ofdan\SearchBundle\Service;

use Doctrine\ORM\EntityManager;
use Ofdan\SearchBundle\Entity\LogSearch;
use Ofdan\SearchBundle\Entity\Domain;

class Results
{
    protected $em;
    protected $time_start;

    protected $max_results;
    protected $results_per_page;
    protected $page = 0;

    protected $queryString;
    protected $queryAny = array();
    protected $queryRequired = array();
    protected $queryExclude = array();

    protected $languageCode;
    
    protected $results;

    public function __construct(EntityManager $em, $max_results, $results_per_page)
    {
        $this->em = $em;

        $this->max_results = $max_results;
        $this->results_per_page = $results_per_page;
    }

    public function setQuery($queryStr)
    {
        $this->time_start = microtime(true);
        $this->queryString = $queryStr;

        $words = explode(' ', $queryStr);
        
        foreach($words as $word) {
            if($word) {
                if('-' == $word[0]) {
                    $this->queryExclude[] = substr($word, 1);
                } else if('+' == $word[0]) {
                    $this->queryRequired[] = substr($word, 1);
                } else {
                    $this->queryAny[] = $word;
                }
            }
        }
    }

    public function setLanguageCode($languageCode) {
        $this->languageCode = $languageCode;
    }

    public function getResults()
    {
        $qb = $this->em->createQueryBuilder('d')
                ->select('d')
                ->from('Ofdan\SearchBundle\Entity\Domain','d')
                ->where('d.status = :status')
                ->setParameter('status', Domain::STATUS_STORED)
        ;

        if(!empty($this->queryExclude) || !empty($this->queryRequired) || !empty($this->queryAny)) {
            
            $qb
                ->leftjoin('Ofdan\SearchBundle\Entity\Rank', 'r', \Doctrine\ORM\Query\Expr\Join::WITH, 'd.id = r.domain')
                ->leftjoin('Ofdan\SearchBundle\Entity\Keyword', 'k', \Doctrine\ORM\Query\Expr\Join::WITH, 'r.keyword = k.id')
                ->groupBy('d.id')
            ;

            if(!empty($this->queryExclude)) {
                $qb->andWhere($qb->expr()->notIn('k.keyword', ':queryExclude'));
                $qb->setParameter('queryExclude', $this->queryExclude);
            }

            if (!empty($this->queryRequired)) {
                foreach ($this->queryRequired as $i => $queryRequired) {
                    $qb->andWhere('k.keyword = :queryRequired'.$i);
                    $qb->setParameter('queryRequired'.$i, $this->queryRequired);
                }
            }
            
            if(!empty($this->queryAny)) {
                $qb->andWhere($qb->expr()->in('k.keyword', ':queryAny'));
                $qb->setParameter('queryAny', $this->queryAny);
            }
        }

        if($this->languageCode) {
            $qb
                ->leftjoin('Ofdan\SearchBundle\Entity\Metadata', 'md')
                ->andWhere('md.domain = d.id')
                ->andWhere('md.lang = :language')
                ->setParameter('language', $this->languageCode)
            ;
        }

        $query = $qb->getQuery();
        $this->results = count($query->getResult());

        $qb
                ->setMaxResults($this->results_per_page)
                ->setFirstResult($this->results_per_page * $this->page)
        ;

        $query = $qb->getQuery();

        $results =  $query->getResult();

        $this->logSearch();
        
        return $results;
    }

    protected function logSearch()
    {
        $logSearch = new LogSearch();
        $logSearch->setIp($_SERVER['REMOTE_ADDR']);
        $logSearch->setDatetime(new \DateTime());
        $logSearch->setQuery($this->queryString);
        $logSearch->setSeek(number_format(microtime(true)-$this->time_start, 2) . "s");
        
        $this->em->persist($logSearch);
        $this->em->flush();
    }
    
    protected function setPage($page)
    {
        $this->page = $page -1;
    }
    
    public function getResultCount()
    {
        return $this->results;
    }

    public function __toString()
    {
        return 'Oh no';
    }
}

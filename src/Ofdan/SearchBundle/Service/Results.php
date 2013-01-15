<?php

namespace Ofdan\SearchBundle\Service;

use Doctrine\ORM\EntityManager;
use Ofdan\SearchBundle\Entity\LogSearch;
use Ofdan\SearchBundle\Entity\Domain;

class Results
{
    protected $em;

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
        $this->em;
        
        $qb = $this->em->createQueryBuilder('d')
                ->select('d')
                ->from('Ofdan\SearchBundle\Entity\Domain','d')
                ->where('d.status = :status')
                ->setParameter('status', Domain::STATUS_STORED)
        ;

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
/*
        $squirt = "SELECT `domain`.`domain`, SUM(`score`) as rank, COUNT(`domain`) as count
        FROM `keyword2`,`rank2`,`domain`
        $join
        WHERE `domain`.`status`='stored' AND `domain`.`id`=`rank2`.`domainId` AND `keyword2`.`id`=`rank2`.`keyword_id` $qnow
        GROUP BY `domain`.`domain`
        ORDER BY `rank` DESC   ";     
  */

        $this->logSearch();

        return $query->getResult();
    }

    protected function logSearch()
    {
        $logSearch = new LogSearch();
        $logSearch->setIp($_SERVER['REMOTE_ADDR']);
        $logSearch->setDatetime(new \DateTime());
        $logSearch->setQuery($this->queryString);
        $logSearch->setSeek(number_format(preg_replace('/[ ]/', '', microtime()),2) . "s");
        
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

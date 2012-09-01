<?php

namespace Ofdan\SearchBundle\Service;

use Doctrine\ORM\EntityManager;

class Results
{
    protected $em;

    protected $max_results;
    protected $results_per_page;

    protected $queryAny = array();
    protected $queryRequired = array();
    protected $queryExclude = array();

    public function __construct(EntityManager $em, $max_results, $results_per_page)
    {
        $this->em = $em;

        $this->max_results = $max_results;
        $this->results_per_page = $results_per_page;
    }

    public function setQuery($queryStr)
    {
        $words = explode(' ', $queryStr);
        
        foreach($words as $word) {
            if($word) {
                if('-' == $word[0]) {
                    $this->queryExclude = substr($word, 1);
                } else if('+' == $word[0]) {
                    $this->queryRequired = substr($word, 1);
                } else {
                    $this->queryAny = $word;
                }
            }
        }
    }

    public function getResults()
    {
        return array();
    }

    public function __toString()
    {
        return 'Oh no';
    }
}

<?php

namespace Ofdan\SearchBundle\Service;

class Results
{
    protected $max_results;
    protected $results_per_page;
    public function __construct($max_results, $results_per_page)
    {
        $this->max_results = $max_results;
        $this->results_per_page = $results_per_page;
    }

    public function setQuery()
    {
        return array();
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

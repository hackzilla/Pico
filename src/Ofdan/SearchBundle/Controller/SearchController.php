<?php

namespace Ofdan\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class SearchController extends Controller
{
    public function searchboxAction()
    {
        return $this->render('OfdanSearchBundle:Search:searchbox.html.twig', array(
            'query' => $this->getQuery(),
        ));
    }
    
    public function indexAction($query = null)
    {
        return $this->render('OfdanSearchBundle:Search:results.html.twig', array(
            'results' => array(),
            'query' => $this->getQuery($query),
        ));
    }
    
    public function getQuery($query = null)
    {
        if(null === $query) {
            $request = $this->getRequest();
            $query = $request->query->get('q');
        }

        return strip_tags($query).'HUH';
    }
}

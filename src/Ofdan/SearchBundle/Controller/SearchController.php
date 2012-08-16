<?php

namespace Ofdan\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class SearchController extends Controller
{
    public function searchboxAction($query = NULL)
    {
        $request = $this->getRequest();
        $query = $request->query->get('q');

        
var_dump($request);        
var_dump($request->query->all());
var_dump($_GET);
        return $this->render('OfdanSearchBundle:Search:searchbox.html.twig', array(
            'query' => $query,
        ));
    }
    
    public function indexAction($query = null)
    {
        if(null === $query) {
            $request = $this->getRequest();
            $query = $request->query->get('q');
        }

        return $this->render('OfdanSearchBundle:Search:results.html.twig', array(
            'results' => array(),
            'query' => $query,
        ));
    }
}

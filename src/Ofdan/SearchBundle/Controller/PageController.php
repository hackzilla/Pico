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
}

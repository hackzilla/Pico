<?php

namespace Ofdan\CrawlerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('OfdanCrawlerBundle:Default:index.html.twig', array('name' => $name));
    }
}

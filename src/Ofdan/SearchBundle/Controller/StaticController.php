<?php

namespace Ofdan\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class StaticController extends Controller
{
    public function homeAction()
    {
        return $this->render('OfdanSearchBundle::layout.html.twig');
    }

    public function aboutAction()
    {
        return $this->render('OfdanSearchBundle:Static:about.html.twig');
    }
}

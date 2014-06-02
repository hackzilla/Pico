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

    public function licenseAction()
    {
        return $this->render('OfdanSearchBundle:Static:license.html.twig');
    }

    public function downloadAction()
    {
        return $this->render('OfdanSearchBundle:Static:download.html.twig');
    }

}

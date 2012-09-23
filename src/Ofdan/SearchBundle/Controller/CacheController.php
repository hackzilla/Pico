<?php

namespace Ofdan\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class CacheController extends Controller
{  
    public function indexAction()
    {
        $request = $this->getRequest();
        $domain = $request->query->get('domain');
        
        if(null !== $domain) {
            $em = $this->getDoctrine()
                        ->getEntityManager();

            $domainCache = $em->getRepository('OfdanSearchBundle:CacheIndex')
                ->getDomainCache($domain);
            
            if(null !== $domainCache) {
                return $this->render('OfdanSearchBundle:Cache:view.html.twig', array(
                    'domain' => $domain,
                    'base_url' => 'http://'.$domain.'/',
                    'cache' => $domainCache,
                ));
            } else {
                return $this->render('OfdanSearchBundle:Cache:no_cache.html.twig', array(
                    'domain' => $domain,
                ));
            }
        } else {
            return $this->render('OfdanSearchBundle:Cache:no_domain.html.twig');
        }
    }
}

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
        $query = $this->getQuery($query);

        return $this->render('OfdanSearchBundle:Search:results.html.twig', array(
            'results' => $this->getResults($query),
            'suggestion' => $this->getSuggestion($query),
            'query' => $query,
        ));
    }

    public function getSuggestion($query)
    {
        $words = preg_split('/[ ,;.]/', $query );

        $incorrectWords = array();
        $int = pspell_new('en_GB-w-accents');

        if( $int )
        {
            foreach( $words as $word ) {

                if( !pspell_check( $int, $word ) ) {
                    $suggest = pspell_suggest($int, $word);
                    if (isset($suggest[0])) {
                            $incorrectWords[$word] = '<strong>'.$suggest[0].'</strong>';
                    }
                }
            }

            $correctWords = array_values( $incorrectWords );
            $incorrectWords = array_keys( $incorrectWords );

            $checkedStr = str_replace( $incorrectWords, $correctWords, $query );
        } else {
                $checkedStr = NULL;
        }

        return $checkedStr;
    }

    public function getResults($query)
    {
        return array();
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

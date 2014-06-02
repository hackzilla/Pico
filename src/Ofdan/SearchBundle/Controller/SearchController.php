<?php

namespace Ofdan\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SearchController extends Controller
{

    public function searchboxAction()
    {
        return $this->render('OfdanSearchBundle:Search:searchbox.html.twig', array(
                    'query' => $this->getQuery(),
                    'languages' => $this->getLanguages(),
                    'selected_language' => $this->getLanguage(),
        ));
    }

    public function indexAction($query = null)
    {
        $query = $this->getQuery($query);
        $languages = $this->getLanguages();

        $search = $this->get('search_service');
        $search->setQuery($query);
        $search->setLanguageCode($this->getLanguage());

        return $this->render('OfdanSearchBundle:Search:results.html.twig', array(
                    'results' => $search->getResults(),
                    'suggestion' => $this->getSuggestion($query),
                    'query' => $query,
                    'languages' => $languages,
                    'selected_language' => $this->getLanguage(),
        ));
    }

    public function getSuggestion($query)
    {
        $words = preg_split('/[ ,;.]/', $query);

        $incorrectWords = array();
        $int = pspell_new('en_GB-w-accents');

        if ($int) {
            foreach ($words as $word) {

                if (!pspell_check($int, $word)) {
                    $suggest = pspell_suggest($int, $word);
                    if (isset($suggest[0])) {
                        $incorrectWords[$word] = '<strong>' . $suggest[0] . '</strong>';
                    }
                }
            }

            $correctWords = array_values($incorrectWords);
            $incorrectWords = array_keys($incorrectWords);

            $checkedStr = str_replace($incorrectWords, $correctWords, $query);

            if ($checkedStr === $query) {
                $checkedStr = NULL;
            }
        } else {
            $checkedStr = NULL;
        }

        return $checkedStr;
    }

    public function getQuery($query = null)
    {
        if (null === $query) {
            $request = $this->getRequest();
            $query = $request->query->get('q');
        }

        $query = \preg_replace('/([^ ])\+/', '$1 ', $query);

        return strip_tags($query);
    }

    public function getLanguage()
    {
        $request = $this->getRequest();
        $language = $request->query->get('cc');

        return \preg_replace('[^a-z]', '', $language);
    }

    public function getLanguages()
    {
        $em = $this->getDoctrine()
                ->getEntityManager();

        return $em->getRepository('OfdanSearchBundle:Language')
                        ->getLanguages();
    }

}

<?php

namespace Ofdan\SearchBundle\Repository;

use Doctrine\ORM\EntityRepository;

class KeywordRepository extends EntityRepository
{
    public function getKeywordLengths()
    {
        $q = $this->createQueryBuilder('k')
                ->select('MIN(k.length) MinKeyword, MAX(k.length) MaxKeyword, AVG(k.length) AvgKeyword, COUNT(k) KeywordCount');
        
        return $q->getQuery()
                ->getSingleResult();
    }
    
    public function getKeywordMatches($keyword) {
        $q = $this->createQueryBuilder('k')
                ->select('k.keyword')
                ->where('k.keyword LIKE :keyword')
                ->setParameter('keyword', $keyword)
                ->orderBy('k.keyword', 'ASC');

        return $q->getQuery()
                ->getResult();
    }
}

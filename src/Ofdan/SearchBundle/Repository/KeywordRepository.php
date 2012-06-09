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
}

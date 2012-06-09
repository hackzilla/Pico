<?php

namespace Ofdan\SearchBundle\Repository;

use Doctrine\ORM\EntityRepository;

class KeywordRepository extends EntityRepository
{
    public function getKeywordLengths()
    {
        $q = $this->createQueryBuilder('k')
                ->select('MIN(k.length), MAX(k.length), AVG(k.length), COUNT(k)');
        
        return $q->getQuery()
                ->getSingleResult();
    }
}

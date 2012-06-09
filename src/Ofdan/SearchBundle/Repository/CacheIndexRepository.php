<?php

namespace Ofdan\SearchBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CacheIndexRepository extends EntityRepository
{
    public function getIndexCount()
    {
        $qb = $this->createQueryBuilder('d')
                ->select('COUNT(d) IndexCount')
        ;
        
        return $qb->getQuery()
                ->getSingleResult();
    }
}

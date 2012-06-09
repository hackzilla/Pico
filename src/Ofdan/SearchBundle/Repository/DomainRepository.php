<?php

namespace Ofdan\SearchBundle\Repository;

use Doctrine\ORM\EntityRepository;

class DomainRepository extends EntityRepository
{
    public function getDomainCountByStatus()
    {
        $qb = $this->createQueryBuilder('d')
                ->select('d.status, COUNT(d.status) StatusCount')
                ->groupBy('d.status');
        
        return $qb->getQuery()
                ->getResult();
    }
}

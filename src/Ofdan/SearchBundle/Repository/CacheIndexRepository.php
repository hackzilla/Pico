<?php

namespace Ofdan\SearchBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Ofdan\SearchBundle\Entity\Domain;

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
    
    public function getDomainCache($domain)
    {
        $qb = $this->createQueryBuilder('c')
                ->select('c')
                ->from('\Ofdan\SearchBundle\Entity\Domain', 'd')
                ->where('d.domain = :domain')
                ->andWhere('d.status = :status')
                ->andWhere('d.id = c.domain')
                ->setParameter('domain', $domain)
                ->setParameter('status', Domain::STATUS_STORED)
        ;

        $query = $qb->getQuery();

        try {
            $cache = $query->getResult();
            
            if(!empty($cache)) {
                $cache = $cache[0];
            } else {
                $cache = NULL;
            }
        } catch (\Doctrine\Orm\NoResultException $e) {
            $cache = NULL;
        }

        return $cache;
    }
}

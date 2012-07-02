<?php

namespace Ofdan\SearchBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Ofdan\SearchBundle\Entity\Domain;

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
    
    public function getUpdatetoDateDomainCount()
    {
        $qb = $this->createQueryBuilder('d')
                ->select('COUNT(d) UpToDateCount')
                ->where('d.status = ?2')
                ->orWhere('d.nextIndex < ?1')
                ->setParameter(1, date('Y-m-d H:i:s'))
                ->setParameter(2, Domain::STATUS_QUEUE)
        ;
        
        return $qb->getQuery()
                ->getSingleScalarResult();
    }
    
    public function getDomainStatus($domain) {
        $qb = $this->createQueryBuilder('d')
                ->select('d.status')
                ->where('d.domain = :domain')
                ->setParameter('domain', $domain)
        ;

        $query = $qb->getQuery();

        try {
            $status = $query->getSingleScalarResult();
        } catch (\Doctrine\Orm\NoResultException $e) {
            $status = NULL;
        }

        return $status;
    }
}

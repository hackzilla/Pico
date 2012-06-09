<?php

namespace Ofdan\SearchBundle\Repository;

use Doctrine\ORM\EntityRepository;

class LogSearchRepository extends EntityRepository
{
    public function getLatestSearches($limit = null)
    {
        $qb = $this->createQueryBuilder('ls')
                   ->select('ls')
                   ->addOrderBy('ls.createdAt', 'DESC');

        if (false === is_null($limit))
            $qb->setMaxResults($limit);

        return $qb->getQuery()
                  ->getResult();
    }

    public function getTotalSearches()
    {
        $qb = $this->createQueryBuilder('ls')
                   ->select('COUNT(ls)');

        return $qb->getQuery()
                  ->getSingleScalarResult();
    }

    public function getTotalSearches24Hr()
    {
        $qb = $this->createQueryBuilder('ls')
                   ->select('COUNT(ls)')
                   ->where('ls.createdAt > ?1')
                   ->setParameter(1, \date('Y-m-d H:i:s', \strtotime('-24 hour')));

        return $qb->getQuery()
                  ->getSingleScalarResult();
    }

    public function getSeekTimeSearches24Hr()
    {
        $qb = $this->createQueryBuilder('ls')
                   ->select('AVG(ls.seek)')
                   ->where('ls.createdAt > ?1')
                   ->setParameter(1, \date('Y-m-d H:i:s', \strtotime('-24 hour')));

        return $qb->getQuery()
                  ->getSingleScalarResult();
    }
    
    public function getSeekandTotalSearches24Hr()
    {
        $qb = $this->createQueryBuilder('ls')
                   ->select('COUNT(ls) SearchCount, AVG(ls.seek) Seek')
                   ->where('ls.createdAt > ?1')
                   ->setParameter(1, \date('Y-m-d H:i:s', \strtotime('-24 hour')));

        return $qb->getQuery()
                  ->getSingleResult();

    }
}

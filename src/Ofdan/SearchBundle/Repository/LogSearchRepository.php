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
}

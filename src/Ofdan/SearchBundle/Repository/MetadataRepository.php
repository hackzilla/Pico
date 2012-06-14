<?php

namespace Ofdan\SearchBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MetadataRepository extends EntityRepository
{
    public function getDomainWithKnownLangCount()
    {
        $qb = $this->createQueryBuilder('m')
                   ->select('COUNT(m)')
                   ->where('m.lang != ?1')
                   ->setParameter(1, '')
        ;

        return $qb->getQuery()
                  ->getSingleScalarResult();
    }
}

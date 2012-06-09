<?php

namespace Ofdan\SearchBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CacheRobotRepository extends EntityRepository
{
    public function getRobotCount()
    {
        $qb = $this->createQueryBuilder('d')
                ->select('COUNT(d) RobotCount')
        ;
        
        return $qb->getQuery()
                ->getSingleResult();
    }
}

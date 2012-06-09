<?php

namespace Ofdan\SearchBundle\Repository;

use Doctrine\ORM\EntityRepository;

class LanguageRepository extends EntityRepository
{
    public function getKnownLanguages()
    {
        $qb = $this->createQueryBuilder('d')
                ->select('COUNT(d) LanguageCount')
        ;
        
        return $qb->getQuery()
                ->getSingleResult();
    }
}

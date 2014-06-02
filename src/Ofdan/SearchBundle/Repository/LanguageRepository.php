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

    public function getLanguages()
    {
        $qb = $this->createQueryBuilder('l')
                ->select('l.cc, l.nameEng')
                ->orderBy('l.nameEng', 'ASC')
        ;

        return $qb->getQuery()
                        ->getResult();
    }

}

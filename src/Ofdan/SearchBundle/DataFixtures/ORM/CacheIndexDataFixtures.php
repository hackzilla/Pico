<?php

namespace Ofdan\SearchBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Ofdan\SearchBundle\Entity\CacheIndex;

class CacheIndexFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $cacheIndex1 = new CacheIndex();
        $cacheIndex1->setDomain($manager->merge($this->getReference('bbc-domain')));
        $cacheIndex1->setDate(new \DateTime());
        $cacheIndex1->setCompressed(FALSE);
        $cacheIndex1->setIndex('');
        $manager->persist($cacheIndex1);

        $manager->flush();
    }

    public function getOrder()
    {
        return 5; // the order in which fixtures will be loaded
    }
}

<?php

namespace Ofdan\SearchBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Ofdan\SearchBundle\Entity\CacheHeader;

class CacheHeaderFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $cacheHeader1 = new CacheHeader();
        $cacheHeader1->setDomain($manager->merge($this->getReference('bbc-domain')));
        $cacheHeader1->setDate(new \DateTime());
        $cacheHeader1->setPage(CacheHeader::PAGE_INDEX);
        $cacheHeader1->setHeader('');

        $manager->persist($cacheHeader1);

        $cacheHeader2 = new CacheHeader();
        $cacheHeader2->setDomain($manager->merge($this->getReference('github-domain')));
        $cacheHeader2->setDate(new \DateTime());
        $cacheHeader2->setPage(CacheHeader::PAGE_ROBOT);
        $cacheHeader2->setHeader('');
        $manager->persist($cacheHeader2);

        $manager->flush();
    }

    public function getOrder()
    {
        return 4; // the order in which fixtures will be loaded
    }
}

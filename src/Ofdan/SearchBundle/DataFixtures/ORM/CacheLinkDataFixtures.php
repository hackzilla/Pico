<?php

namespace Ofdan\SearchBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Ofdan\SearchBundle\Entity\CacheLink;

class CacheLinkFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $cacheLink1 = new CacheLink();
        $cacheLink1->setDomain($manager->merge($this->getReference('bbc-domain')));
        $cacheLink1->setLinkDomain($manager->merge($this->getReference('github-domain')));
        $cacheLink1->setRank(1);
        $manager->persist($cacheLink1);

        $cacheLink2 = new CacheLink();
        $cacheLink2->setDomain($manager->merge($this->getReference('github-domain')));
        $cacheLink2->setLinkDomain($manager->merge($this->getReference('bbc-domain')));
        $cacheLink2->setRank(1);
        $manager->persist($cacheLink2);

        $manager->flush();
    }

    public function getOrder()
    {
        return 6; // the order in which fixtures will be loaded
    }
}

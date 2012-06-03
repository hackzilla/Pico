<?php

namespace Ofdan\SearchBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Ofdan\SearchBundle\Entity\Rank;

class RankFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $rank1 = new Rank();
        $rank1->setDomain($manager->merge($this->getReference('bbc-domain')));
        $rank1->setKeyword($manager->merge($this->getReference('mainpage-keyword')));
        $rank1->setScore(5);
        $manager->persist($rank1);

        $rank2 = new Rank();
        $rank2->setDomain($manager->merge($this->getReference('github-domain')));
        $rank2->setKeyword($manager->merge($this->getReference('enterprise-keyword')));
        $rank2->setScore(10);
        $manager->persist($rank2);

        $manager->flush();
    }

    public function getOrder()
    {
        return 10; // the order in which fixtures will be loaded
    }
}

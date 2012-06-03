<?php

namespace Ofdan\SearchBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Ofdan\SearchBundle\Entity\CacheRobot;

class CacheRobotFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $cacheRobot1 = new CacheRobot();
        $cacheRobot1->setDomain($manager->merge($this->getReference('bbc-domain')));
        $cacheRobot1->setDate(new \DateTime());
        $cacheRobot1->setRobot('
User-agent: *
Disallow: /');
        $manager->persist($cacheRobot1);

        $cacheRobot2 = new CacheRobot();
        $cacheRobot2->setDomain($manager->merge($this->getReference('github-domain')));
        $cacheRobot2->setDate(new \DateTime());
        $cacheRobot2->setRobot('
User-agent: *
Disallow: /cgi-bin/
Disallow: /tmp/
Disallow: /~joe/');
        $manager->persist($cacheRobot2);

        $cacheRobot3 = new CacheRobot();
        $cacheRobot3->setDomain($manager->merge($this->getReference('slashdot-domain')));
        $cacheRobot3->setDate(new \DateTime());
        $cacheRobot3->setRobot('');
        $manager->persist($cacheRobot3);

        $manager->flush();
    }

    public function getOrder()
    {
        return 7; // the order in which fixtures will be loaded
    }
}

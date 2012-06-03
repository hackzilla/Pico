<?php

namespace Ofdan\SearchBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Ofdan\SearchBundle\Entity\LogSearch;

class LogSearchFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $logSearch1 = new LogSearch();
        $logSearch1->setIp('127.0.0.1');
        $logSearch1->setDatetime(new \DateTime());
        $logSearch1->setQuery('search engine');
        $logSearch1->setSeek('0.656');
        $manager->persist($logSearch1);

        $logSearch2 = new LogSearch();
        $logSearch2->setIp('192.168.0.1');
        $logSearch2->setDatetime(new \DateTime());
        $logSearch2->setQuery('programming');
        $logSearch2->setSeek('10.001');
        $manager->persist($logSearch2);

        $logSearch3 = new LogSearch();
        $logSearch3->setIp('192.168.0.2');
        $logSearch3->setDatetime(new \DateTime());
        $logSearch3->setQuery('symfony2');
        $logSearch3->setSeek('0.6');
        $manager->persist($logSearch3);

        $manager->flush();
    }

    public function getOrder()
    {
        return 9; // the order in which fixtures will be loaded
    }
}

<?php

namespace Ofdan\SearchBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Ofdan\SearchBundle\Entity\LogBlock;

class LogBlockFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $logBlock1 = new LogBlock();
        $logBlock1->setDomain($manager->merge($this->getReference('bbc-domain')));
        $logBlock1->setDate(new \DateTime());
        $logBlock1->setReason('robot');
        $logBlock1->setInfo('Denied by Robot File');
        $manager->persist($logBlock1);

        $logBlock2 = new LogBlock();
        $logBlock2->setDomain($manager->merge($this->getReference('github-domain')));
        $logBlock2->setDate(new \DateTime());
        $logBlock2->setReason('connection');
        $logBlock2->setInfo('Problem connecting');
        $manager->persist($logBlock2);

        $logBlock3 = new LogBlock();
        $logBlock3->setDomain($manager->merge($this->getReference('slashdot-domain')));
        $logBlock3->setDate(new \DateTime());
        $logBlock3->setReason('');
        $logBlock3->setInfo('');
        $manager->persist($logBlock3);

        $manager->flush();
    }

    public function getOrder()
    {
        return 8; // the order in which fixtures will be loaded
    }
}

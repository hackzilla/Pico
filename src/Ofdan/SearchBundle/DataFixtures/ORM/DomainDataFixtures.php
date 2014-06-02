<?php

namespace Ofdan\SearchBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Ofdan\SearchBundle\Entity\Domain;

class DomainFixtures extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $domain1 = new Domain();
        $domain1->setRank(1);
        $domain1->setStatus(Domain::STATUS_QUEUE);
        $domain1->setDomain('www.bbc.co.uk');
        $manager->persist($domain1);

        $domain2 = new Domain();
        $domain2->setRank(1);
        $domain2->setStatus(Domain::STATUS_STORED);
        $domain2->setDomain('github.com');
        $manager->persist($domain2);

        $domain3 = new Domain();
        $domain3->setRank(1);
        $domain3->setStatus(Domain::STATUS_PROCESSING);
        $domain3->setDomain('slashdot.org');
        $manager->persist($domain3);

        $domain4 = new Domain();
        $domain4->setRank(1);
        $domain4->setStatus(Domain::STATUS_PAUSED);
        $domain4->setDomain('open.gov.uk');
        $manager->persist($domain4);

        $manager->flush();

        $this->addReference('bbc-domain', $domain1);
        $this->addReference('github-domain', $domain2);
        $this->addReference('slashdot-domain', $domain3);
        $this->addReference('open-domain', $domain4);
    }

    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }

}

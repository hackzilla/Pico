<?php

namespace Ofdan\SearchBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Ofdan\SearchBundle\Entity\Metadata;

class MetadataFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $metadata1 = new Metadata();
        $metadata1->setDomain($manager->merge($this->getReference('bbc-domain')));
        $metadata1->setLang('en');
        $metadata1->setDialect('us');
        $metadata1->setExtract('The initial installation of Debian Apache.');
        $manager->persist($metadata1);

        $metadata2 = new Metadata();
        $metadata2->setDomain($manager->merge($this->getReference('github-domain')));
        $metadata2->setLang('en');
        $metadata2->setDialect('us');
        $metadata2->setExtract('The initial installation of Debian Apache.');
        $manager->persist($metadata2);

        $metadata3 = new Metadata();
        $metadata3->setDomain($manager->merge($this->getReference('slashdot-domain')));
        $metadata3->setLang('en');
        $metadata3->setDialect('us');
        $metadata3->setExtract('The initial installation of Debian Apache.');
        $manager->persist($metadata3);

        $metadata4 = new Metadata();
        $metadata4->setDomain($manager->merge($this->getReference('open-domain')));
        $metadata4->setLang('en');
        $metadata4->setDialect('us');
        $metadata4->setExtract('The initial installation of Debian Apache.');
        $manager->persist($metadata4);

        $manager->flush();
    }

    public function getOrder()
    {
        return 7; // the order in which fixtures will be loaded
    }
}

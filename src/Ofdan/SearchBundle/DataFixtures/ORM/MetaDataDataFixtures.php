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

        $manager->flush();
    }

    public function getOrder()
    {
        return 7; // the order in which fixtures will be loaded
    }
}

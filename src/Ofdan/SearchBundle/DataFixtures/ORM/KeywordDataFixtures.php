<?php

namespace Ofdan\SearchBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Ofdan\SearchBundle\Entity\Keyword;

class KeywordFixtures extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $keyword1 = new Keyword();
        $keyword1->setKeyword('mainpage');
        $manager->persist($keyword1);

        $keyword2 = new Keyword();
        $keyword2->setKeyword('enterprise');
        $manager->persist($keyword2);

        $keyword3 = new Keyword();
        $keyword3->setKeyword('linux');
        $manager->persist($keyword3);

        $keyword4 = new Keyword();
        $keyword4->setKeyword('resource');
        $manager->persist($keyword4);

        $keyword5 = new Keyword();
        $keyword5->setKeyword('application');
        $manager->persist($keyword5);

        $manager->flush();

        $this->addReference('mainpage-keyword', $keyword1);
        $this->addReference('enterprise-keyword', $keyword2);
        $this->addReference('linux-keyword', $keyword3);
        $this->addReference('resource-keyword', $keyword4);
        $this->addReference('aplication-keyword', $keyword5);
    }

    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }

}

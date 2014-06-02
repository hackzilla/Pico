<?php

namespace Ofdan\SearchBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Ofdan\SearchBundle\Entity\Language;

class LanguageFixtures extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $language1 = new Language();
        $language1->setCc('en');
        $language1->setNameEng('English');
        $manager->persist($language1);

        $language2 = new Language();
        $language2->setCc('fr');
        $language2->setNameEng('French');
        $manager->persist($language2);

        $language3 = new Language();
        $language3->setCc('de');
        $language3->setNameEng('German');
        $manager->persist($language3);

        $language4 = new Language();
        $language4->setCc('es');
        $language4->setNameEng('Spanish');
        $manager->persist($language4);

        $language5 = new Language();
        $language5->setCc('pt');
        $language5->setNameEng('Portuguese');
        $manager->persist($language5);

        $manager->flush();

        $this->addReference('en-language', $language1);
        $this->addReference('fr-language', $language2);
        $this->addReference('de-language', $language3);
        $this->addReference('es-language', $language4);
        $this->addReference('pt-language', $language5);
    }

    public function getOrder()
    {
        return 3; // the order in which fixtures will be loaded
    }

}

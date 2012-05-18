<?php

namespace Ofdan\SearchBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ofdan\SearchBundle\Entity\Language;

class LanguageFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $language1 = new Language();
        $language1->setCc('en');
        $language1->setNameEng('English');
        $language1->setCreatedAt(new \DateTime());
        $manager->persist($language1);

        $language2 = new Language();
        $language2->setCc('fr');
        $language2->setNameEng('French');
        $language2->setCreatedAt(new \DateTime());
        $manager->persist($language2);

        $language3 = new Language();
        $language3->setCc('de');
        $language3->setNameEng('German');
        $language3->setCreatedAt(new \DateTime());
        $manager->persist($language3);

        $language4 = new Language();
        $language4->setCc('es');
        $language4->setNameEng('Spanish');
        $language4->setCreatedAt(new \DateTime());
        $manager->persist($language4);

        $language5 = new Language();
        $language5->setCc('pt');
        $language5->setNameEng('Portuguese');
        $language5->setCreatedAt(new \DateTime());
        $manager->persist($language5);
        
        $manager->flush();
    }

}

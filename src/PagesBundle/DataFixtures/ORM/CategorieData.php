<?php

// src/AppBundle/DataFixtures/ORM/LoadUserData.php
/**
 * juste for my personnal test 
 */

namespace PagesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use journalBundle\Entity\categorie;

class CategorieMedia extends AbstractFixture implements OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
        $media1 = new categorie();
        $media1->setNom("Abonnements");
        $media1->setImage($this->getReference("mediaAB"));
        $manager->persist($media1);
        
        $media2 = new categorie();
        $media2->setNom("Achats");
        $media2->setImage($this->getReference("mediaAC"));
        $manager->persist($media2);

        $manager->flush();
        $this->addReference('catmedia1', $media1);
        $this->addReference('catmedia2', $media2);
    
    }
    
    public function getorder(){
        return 2; 
    }
}


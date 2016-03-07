<?php

// src/AppBundle/DataFixtures/ORM/LoadUserData.php
/**
 * juste for my personnal test 
 */

namespace PagesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use journalBundle\Entity\Tva;

class TvaieMedia extends AbstractFixture implements OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
        $media1 = new Tva();
        $media1->setMultiplication(0.82);
        $media1->setNom('TVA 18%');
        $media1->setValeur('18');
        $manager->persist($media1);
        
        
        $media2 = new Tva();
        $media2->setMultiplication(0.80);
        $media2->setNom('TVA 20%');
        $media2->setValeur('20');
        $manager->persist($media2);
           
        $media3 = new Tva();
        $media3->setMultiplication(0.945);
        $media3->setNom('TVA 5.5%');
        $media3->setValeur('5.5');
        $manager->persist($media3);        
        $manager->flush();
        $this->addReference('tva1', $media1);
        $this->addReference('tva2', $media2);
        $this->addReference('tva3', $media3);
    }
    
    public function getorder(){
        return 3; 
    }
}


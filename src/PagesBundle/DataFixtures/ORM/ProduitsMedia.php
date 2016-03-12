<?php

// src/AppBundle/DataFixtures/ORM/LoadUserData.php
/**
 * juste for my personnal test 
 */

namespace PagesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use journalBundle\Entity\Produits;

class ProduitsMedia extends AbstractFixture implements OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
        $media1 = new Produits();
        $media1->setDescription("Le Journal Essor");
        $media1->setNom("Journal Essor");
        $media1->setImage($this->getreference("media1"));
        $media1->setCategorie($this->getReference("catmedia1"));
        $media1->setDisponible(1);
        $media1->setTva($this->getReference("tva1"));
        $media1->setPrix(20000);
        $manager->persist($media1);
         
        $media2 = new Produits();
        $media2->setDescription("le journal de  de la democration au Mali");
        $media2->setNom("Journal Info Matin");
        $media2->setImage($this->getreference("media2"));
        $media2->setCategorie($this->getReference("catmedia2"));
        $media2->setDisponible(1);
        $media2->setTva($this->getReference("tva2"));
         $media2->setPrix(600);
        $manager->persist($media2);
      
        $media3 = new Produits();
        $media3->setDescription("le Journal Economique du Mali ");
        $media3->setNom("Journal Mali Kunafoni");
        $media3->setImage($this->getreference("media3"));
        $media3->setCategorie($this->getReference("catmedia1"));
        $media3->setDisponible(1);
        $media3->setTva($this->getReference("tva2"));
        $media3->setPrix(19000);
        $manager->persist($media3);
      
        $manager->flush();
      
    }

    public function getorder() {
        return 4;
    }

}

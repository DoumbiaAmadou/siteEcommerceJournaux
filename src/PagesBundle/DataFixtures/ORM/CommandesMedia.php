<?php

// src/AppBundle/DataFixtures/ORM/LoadUserData.php
/**
 * juste for my personnal test 
 */

namespace PagesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use journalBundle\Entity\UtilisateursAdresses ;

class UtilisateursAdresseMedia extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface{

    public function load(ObjectManager $manager) {
        
        
        $media1 = new UtilisateursAdresses();
        $media1->setAdresse(" 3 rue eric tabarly");
        $media1->setVille('Massy');
        $media1->setPays('France');
        $media1->setComplement('6 eme étage');
        $media1->setTelephone('062519660');
        $media1->setCp(91300);
        $media1->setPrenom('amadou');
        $media1->setNom("Doumbia");
        $media1->setUtilisateur($this->getReference('u2'));
        
        $manager->persist($media1);
       
        
          $media2 = new UtilisateursAdresses();
        $media2->setAdresse(" rue 143 porte 118 ");
        $media2->setVille('Kalaban coro');
        $media2->setPays('Mali');
        $media2->setComplement('au 1 er etage');
        $media2->setTelephone('062519660');
        $media2->setCp(91300);
        $media2->setPrenom('malamine');
        $media2->setNom("Doumbia");
        $media2->setUtilisateur($this->getReference('u1'));
     
        $manager->persist($media2);
        
        $manager->flush();
        
        
    }

    public function getorder() {
        return 6;
    }

    public function setContainer(ContainerInterface $container = null) {
          $this->container = $container;
    }

}

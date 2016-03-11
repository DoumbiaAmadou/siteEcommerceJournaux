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
use UtilisateurBundle\Entity\Utilisateur ;

class UtilisateurMedia extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface{

    public function load(ObjectManager $manager) {
        $media1 = new Utilisateur();
        $media1->setUsername("malamine");
        $media1->setEmail("malamine14@hotmail.fr");
        $media1->setEnabled(true);
        $media1->setPassword($this->container->get('security.encoder_factory')
                ->getEncoder($media1)
                ->encodePassword('malamine',$media1->getSalt()));
        
        $manager->persist($media1);
       
       $media2 = new Utilisateur();
        $media2->setUsername("karamoko");
        $media2->setEmail("karamoko14@hotmail.fr");
        $media2->setEnabled(true);
        $media2->setPassword($this->container->get('security.encoder_factory')
                ->getEncoder($media2)
                ->encodePassword('karamoko',$media2->getSalt()));
        
        $manager->persist($media2);

        $manager->flush();
        $this->addReference('u1', $media1);
        $this->addReference('u2', $media2);

    }

    public function getorder() {
        return 5;
    }

    public function setContainer(ContainerInterface $container = null) {
          $this->container = $container;
    }

}

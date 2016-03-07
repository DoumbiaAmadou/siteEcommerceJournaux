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
use journalBundle\Entity\Commandes;

class CommandesAdresseMedia extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

    public function load(ObjectManager $manager) {


        $media1 = new Commandes();

        $media1->setUtilisateur($this->getReference('u2'));
        $media1->setUtilisateur($this->getReference('u1'));
        $media1->setValider('1');
        $media1->setDate(new \Datetime());
        $media1->setReference('1');
        $media1->setProduits(array(  '0' => array('1' => '4'),
                                '1' => array('2' => '2'),
                                )
                            );
        $manager->persist($media1);

        $manager->flush();
    }

    public function getorder() {
        return 6;
    }

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

}

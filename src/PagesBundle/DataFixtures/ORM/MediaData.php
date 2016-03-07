<?php
// src/AppBundle/DataFixtures/ORM/LoadUserData.php
/**
 * juste for my personnal test 
 */

namespace PagesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use journalBundle\Entity\Media;

class MediaData extends AbstractFixture implements OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
        
        
        $mediaAB = new Media();
        $mediaAB->setAlt("Abonnements");
        $mediaAB->setPath('{{asset(\'img/abonnezVous.png\')}}');
        $manager->persist($mediaAB);
         $mediaAC = new Media();
        $mediaAC->setAlt("Achats");
        $mediaAC->setPath('{{asset(\'img/acheter.png\')}}');
        $manager->persist($mediaAC);
        $media1 = new Media();
        $media1->setAlt("essor");
        $media1->setPath('http://www.essor.ml/wp-content/themes/essor/images/logo-dark.png');
        $manager->persist($media1);

        $media2 = new Media();
        $media2->setAlt("Info Matin");
        $media2->setPath('http://pmcdn.priceminister.com/photo/info-matin-n-354-du-25-05-1995-guy-dejouany-le-pdg-de-la-generale-des-eaux-mis-en-examen-l-irlande-a-washington-hlm-un-fidele-de-chirac-mis-en-examen-reformes-sociales-ou-trouver-les-sous-le-journal-des-municipales-a-nice-cannes-1007498700_ML.jpg');
        $manager->persist($media2);

     
        
        
        $media3 = new Media();
        $media3->setAlt("Mali Kunafoni");
        $media3->setPath('https://image.jimcdn.com/app/cms/image/transf/dimension=330x1024:format=jpg/path/s93a089e570be78ac/image/i022f488913fb89b0/version/1279202464/image.jpg');
        $manager->persist($media3);
     
        
        
        
        
        
        
        
        
        $manager->flush();
        $this->addReference('mediaAB', $mediaAB);
        $this->addReference('mediaAC', $mediaAC);
        $this->addReference('media1', $media1);
        $this->addReference('media2', $media2);
        $this->addReference('media3', $media3);

    }
    
    public function getorder(){
        return 1; 
    }
}
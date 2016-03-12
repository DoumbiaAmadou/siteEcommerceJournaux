<?php
namespace journalBundle\Twig\Extension; 


class TvaExtension extends \Twig_Extension
{
    
    public function getFilters(){
        return array( 
            new \Twig_SimpleFilter('tva', array($this , 'calculTva'))
            );
    }
    
    function calculTva($prixNt ,$tva){
        return round($prixNt*$tva,2);
    }
    public function getName()
    {
        return 'twig.extension'; 
    }
}
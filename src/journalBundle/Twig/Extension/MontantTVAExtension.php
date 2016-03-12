<?php
namespace journalBundle\Twig\Extension; 


class MontantTVAExtension extends \Twig_Extension
{
    
    public function getFilters(){
        return array( 
            new \Twig_SimpleFilter('MontantTVA', array($this , 'calculMontantTVA'))
            );
    }
    
    function calculMontantTVA($prixNt ,$tva){
        $ans = $prixNt*$tva ; 
        $ans = $ans -$prixNt; 
        return round($ans,2);
    }
    public function getName()
    {
        return 'Montant_Tva'; 
    }
}
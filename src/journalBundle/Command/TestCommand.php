<?php
namespace journalBundle\Command ; 

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand ; 
use Symfony\Component\Console\Input\InputArgument; 
use Symfony\Component\Console\Input\InputInterface; 
use Symfony\Component\Console\Input\InputOption; 
use Symfony\Component\Console\Output\OutputInterface; 
use \Symfony\Component\HttpFoundation\Response;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TestCommand  extends ContainerAwareCommand{
    
    
    protected function configure() {
        $this->setName('journal:facture')
                ->setDescription('ceci est un test')
                ->addArgument('date' , InputArgument::OPTIONAL , 'la date pour la quelle vous voulez avoir les factures'); 
                
    }
    protected function execute(InputInterface $input, OutputInterface $output) {
       $date = new \DateTime() ; 
       $em = $this->getContainer()->get('doctrine')->getManager();
       $factures = $em->getRepository('journalBundle:Commandes')->byDateCommand($input->getArgument('date'));
        $output->writeln(count($factures).' facture(s) .');
        if (count($factures) > 0) {
            $dir=$date->format('Y_m_d_H_i_s'); 
            \mkdir('Factures/'.$dir);
            foreach ($factures as $facture){
            $this->getContainer()->get('getFacture')->facture($facture)->output('Factures/'.$dir.'/Facture' .$facture->getReference() . '.pdf', 'F');
            }
        }
//        $this->getContainer()->get('getFacture')->facture($facture)->output('Factures/'.date_format($date, 'Y_m_d_H_i_s').'facture.pdf' , 'F'); 
//       $output->writeln("Bonjour felicitation voici votre premier test  "); 
    
    }
    
    
}
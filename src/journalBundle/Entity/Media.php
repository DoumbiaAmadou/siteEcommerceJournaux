<?php

namespace journalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints  as Assert ; 

/**
 * Media
 *
 * @ORM\Table(name="media")
 * @ORM\Entity(repositoryClass="journalBundle\Repository\MediaRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Media
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @ORM\Column(name="name",type="string",length=255)
     * @Assert\NotBlank
     */
    public $name ;
    
    
    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    public $path ; 

    
    public $file;
    
    
    public function getUploadRootDir()
    {
        return __DIR__.'../../../../web/uploads' ; 
    }
    public function getAbsolutePath(){
        return  null === $this->path 
                ? null 
                : $this->getUploadRootDir().'/'.$this->path ; 
    }
   
    /**
     * @var \DateTime 
     * @ORM\Column(name="updateTime" ,type="datetime" , nullable= true )
     */
    private  $updateTime ; 
    
    /**
     * @ORM\PostLoad()
     */
    public function postLoad(){
        $this->updateTime = new \DateTime() ; 
    }
        /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload(){
         if(file_exists($this->getUploadRootDir())){
             $this->tmpFile = $this->getAbsolutePath() ; 
             $this->oldFile = $this->getPath() ; 
             $this->updateTime = new \DateTime();
         }
         else
         {
                $this->tmpFile = null ; 
                $this->oldFile = null ; 
         }
        if(null !== $this->file){
            $this->path = sha1(uniqid(mt_rand(), true)).'.'.$this->file->guessExtension();
        }
    }
       /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload(){
        
       if(null !== $this->file){
           $this->file->move($this->getUploadRootDir(),$this->path); 
           unset($this->file); 
           
           if($this->oldFile!=null) unlink ($this->tmpFile);
               
       }
    }
    
    /**
     * @ORM\PreRemove()
     * 
     */
    public function preRemoveUpload(){
        $this->tmpFile = $this->getAbsolutePath(); 
        
    }
    /**
     * @ORM\PostRemove()
     */
    public function removeUpload(){
        if(file_exists($this->tmpFile)) unlink ($this->tmpFile); 
    }
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Media
     */
    public function getName()
    {
       return $this->name;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

   public function gertAssertPath(){
       return 'uploads/'.$this->path ; 
   } 
    
}

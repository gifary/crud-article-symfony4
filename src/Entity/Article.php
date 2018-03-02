<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     @Assert\NotBlank()
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     @Assert\NotBlank()
     */
    private $content;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent(){
    	return $this->content;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setContent($content){
    	$this->content = $content;
    }
}

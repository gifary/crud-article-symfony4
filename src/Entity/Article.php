<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

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
     * @Gedmo\Translatable
     * @ORM\Column(type="text")
     @Assert\NotBlank()
     */
    private $content;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string",length=16)
     */
    private $code;

    /**
     * @Gedmo\Translatable
     * @Gedmo\Slug(fields={"title", "code"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

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

    public function getSlug()
    {
        return $this->slug;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setContent($content){
    	$this->content = $content;
    }
}

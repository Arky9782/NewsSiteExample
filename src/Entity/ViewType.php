<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ViewTypeRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ViewType
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="viewType")
     */
    private $post;

    /**
     * @ORM\OneToMany(targetEntity="UzPost", mappedBy="viewType")
     */
    private $postUz;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\PrePersist()
     */
    public function setCreateAtPrePersist()
    {
        $this->created_at = new \DateTime("now");
    }
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPost() :Post
    {
        return $this->post;
    }

    /**
     * @param mixed $post
     */
    public function setPost($post): void
    {
        $this->post = $post;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @param mixed $name
     * @return ViewType
     */
    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPostUz()
    {
        return $this->postUz;
    }

    /**
     * @param mixed $postUz
     */
    public function setPostUz($postUz): void
    {
        $this->postUz = $postUz;
    }
}

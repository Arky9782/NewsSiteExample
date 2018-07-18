<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Tag
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
     * @ORM\ManyToMany(targetEntity="Post", mappedBy="tags", cascade={"persist"})
     */
    protected $posts;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist()
     */
    public function setCreatedAtPrePersist()
    {
        $this->created_at = new \DateTime("now");
    }

    /**
     * @ORM\PreUpdate()
     */
    public function setCreatedAtPreUpdate()
    {
        $this->created_at = new \DateTime("now");
    }

    public function getPosts()
    {
        return $this->posts;
    }


    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPost()
    {
        return $this->posts;
    }

    /**
     * @param Post $post
     * @return $this
     */
    public function addPost(Post $post)
    {

        $post->addTag($this);
        $this->posts[] = $post;

        return $this;

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
}

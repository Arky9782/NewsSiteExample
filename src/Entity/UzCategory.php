<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UzCategoryRepository")
 */
class UzCategory
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
     * @ORM\OrderBy({"created_at" = "DESC"})
     * @ORM\OneToOne(targetEntity="UzPost", mappedBy="category")
     */
    private $posts;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
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

    public function getPosts()
    {
        return $this->posts;
    }

    public function getLimitedPosts()
    {
        return $this->posts->slice(0, 4);
    }

    public function setPosts($post): void
    {
        $this->posts = $post;
    }
}

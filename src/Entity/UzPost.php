<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(indexes={@ORM\Index(columns={"title"},flags={"fulltext"})})
 * @ORM\Entity(repositoryClass="App\Repository\UzPostRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class UzPost
{
    const PATH_TO_IMAGE_FOLDER = './upload/images/';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $subtitle;

    /**
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="boolean")
     */
    private $main;

    /**
     * @ORM\Column(type="boolean")
     */
    private $draft;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $raw_body;

    /**
     * @ORM\OneToMany(targetEntity="UzTag", mappedBy="post", cascade={"all"})
     */
    protected $tags;

    /**
     * @ORM\ManyToOne(targetEntity="Author", inversedBy="posts")
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="ViewType", inversedBy="postUz")
     */
    private $viewType;

    /**
     * @ORM\OneToOne(targetEntity="UzCategory", inversedBy="posts")
     */
    private $category;


    private $file;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;


    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }


    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(?string $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function addTag($tag)
    {
        $this->tags->add($tag);
    }

    /**
     * @return mixed
     */
    public function getDraft()
    {
        return $this->draft;
    }

    /**
     * @param mixed $draft
     */
    public function setDraft($draft): void
    {
        $this->draft = $draft;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param mixed $tags
     */
    public function setTags($tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @return mixed
     */
    public function getRawBody()
    {
        return $this->raw_body;
    }

    /**
     * @param mixed $raw_body
     */
    public function setRawBody($raw_body): void
    {
        $this->raw_body = $raw_body;
    }

    public function upload()
    {
        if ($this->file === null) {
            return;
        }

        $file = $this->getFile();

        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        // moves the file to the directory where brochures are stored
        $file->move(
            self::PATH_TO_IMAGE_FOLDER,
            $fileName
        );

        // updates the 'brochure' property to store the PDF file name
        // instead of its contents
        $this->setImage($fileName);

        // clean up the file property as you won't need it anymore
        $this->setFile(null);
    }

    /**
     * @ORM\PrePersist
     */
    public function lifecycleFileUploadPrePersist()
    {
        $this->upload();
        $this->created_at = new \DateTime("now");
    }

    /**
     * @ORM\PreUpdate
     */
    public function lifecycleFileUploadPreUpdate()
    {
        $this->upload();
    }

    /**
     * Updates the hash value to force the preUpdate and postUpdate events to fire
     */
    public function refreshUpdated()
    {
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file): void
    {
        $this->file = $file;
    }

    /**
     * @return mixed
     */
    public function getMain()
    {
        return $this->main;
    }

    /**
     * @param mixed $main
     */
    public function setMain($main): void
    {
        $this->main = $main;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author): void
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getViewType()
    {
        return $this->viewType;
    }

    /**
     * @param mixed $viewType
     */
    public function setViewType($viewType): void
    {
        $this->viewType = $viewType;
    }
}

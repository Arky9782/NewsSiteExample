<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AuthorRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Author
{
    const PATH_TO_IMAGE_FOLDER = './upload/images/';
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fullname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $avatar;

    private $file;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="author")
     */
    private $posts;


    public function upload()
    {
        $file = $this->getFile();

        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        // moves the file to the directory where brochures are stored
        $file->move(
            self::PATH_TO_IMAGE_FOLDER,
            $fileName
        );

        // updates the 'brochure' property to store the PDF file name
        // instead of its contents
        $this->setAvatar($fileName);

        // clean up the file property as you won't need it anymore
        $this->setFile(null);
    }

    /**
     * @ORM\PrePersist
     */
    public function lifecycleFileUploadPrePersist()
    {
        $this->upload();
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


    public function getId()
    {
        return $this->id;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * @param mixed $post
     */
    public function setPost($post): void
    {
        $this->posts = $post;
    }
}

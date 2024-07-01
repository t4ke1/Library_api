<?php

namespace App\Entity;

use App\Repository\BookRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ORM\Table(name: 'book')]
#[ORM\HasLifecycleCallbacks]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', unique: true, nullable: false)]
    private int $id;

    #[ORM\Column(type: 'string', nullable: false)]
    private string $title;

    #[ORM\Column(type: 'date', nullable: false)]
    private ?\DateTime $publishYear;

    /**
     * Many books have many authors.
     */
    #[ORM\ManyToMany(targetEntity: Author::class, inversedBy: 'books')]
    private Collection $authors;

    /**
     * Many books have one publisher. This is the owning side.
     */
    #[ORM\ManyToOne(targetEntity: Publisher::class, inversedBy: 'books')]
    private ?Publisher $publisher = null;

    #[ORM\Column(type: 'datetime', nullable: false)]
    private ?\DateTime $createdAt;
    #[ORM\Column(type: 'datetime', nullable: false)]
    private \DateTime $updatedAt;


    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPublishYear(): ?\DateTime
    {
        return $this->publishYear;
    }

    public function setPublishYear(?\DateTime $publishYear): self
    {
        $this->publishYear = $publishYear;

        return $this;
    }

    public function __construct()
    {
        $this->authors = new ArrayCollection();
    }
    public function getAuthors(): Collection
    {
        return $this->authors;
    }
    public function addAuthor(Author $author): void
    {
        $this->authors->add($author);
    }
    public function removeAuthor(Author $author): void
    {
        $this->authors->removeElement($author);
    }

    public function getPublisher(): ?Publisher
    {
        return $this->publisher;
    }

    public function setPublisher(?Publisher $publisher): self
    {
        $this->publisher = $publisher;

        return $this;
    }
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    #[ORM\PrePersist]
    public function prePersist(): void
    {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

    #[ORM\PreUpdate]
    public function preUpdate(): void
    {
        $this->updatedAt = new DateTime();
    }
}

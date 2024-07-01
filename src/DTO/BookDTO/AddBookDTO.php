<?php

namespace App\DTO\BookDTO;

use App\DTO\DtoResolvedInterface;
use Symfony\Component\Validator\Constraints as Assert;
class AddBookDTO implements DtoResolvedInterface
{

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    private string $title;
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Regex(
        pattern: '/^\d{4}\.\d{2}\.\d{2}$/',
        message: 'The date must be in the format yyyy.mm.dd.'
    )]
    private string $publishDate;
    #[Assert\NotBlank]
    #[Assert\Type('array')]
    #[Assert\All([
        new Assert\Type('integer')
    ])]
    private array $authorId;
    #[Assert\NotBlank]
    #[Assert\Type('int')]
    private int $publisherId;

    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getPublishDate(): string
    {
        return $this->publishDate;
    }
    public function setPublishDate(string $publishDate): self
    {
        $this->publishDate = $publishDate;
        return $this;
    }

    public function getAuthorId(): array
    {
        return $this->authorId;
    }
    public function setAuthorId(array $authorId): self
    {
        $this->authorId = $authorId;
        return $this;
    }

    public function getPublisherId(): int
    {
        return $this->publisherId;
    }
    public function setPublisherId(int $publisherId): self
    {
        $this->publisherId = $publisherId;
        return $this;
    }
}
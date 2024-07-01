<?php

namespace App\DTO\PublisherDTO;

use App\DTO\DtoResolvedInterface;
use Symfony\Component\Validator\Constraints as Assert;

class UpdatePublisherDTO implements DtoResolvedInterface
{
    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    private int $id;

    #[Assert\Type('string')]
    private ?string $name;

    #[Assert\Type('string')]
    private ?string $address;

    public function getId(): string
    {
        return $this->id;
    }
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }
    public function getName(): ?string
    {
        return $this->name;
    }
    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;

    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;
        return $this;
    }
}

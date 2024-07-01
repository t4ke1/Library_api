<?php

namespace App\DTO\AuthorDTO;

use App\DTO\DtoResolvedInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CreateAuthorDTO implements DtoResolvedInterface
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    private string $firstName;
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    private string $lastName;

    public function getFirstName(): string
    {
        return $this->firstName;
    }
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }
}

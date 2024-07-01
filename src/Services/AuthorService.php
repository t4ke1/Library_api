<?php

namespace App\Services;

use App\DTO\AuthorDTO\CreateAuthorDTO;
use App\Entity\Author;
use App\Exception\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class AuthorService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }
    public function createAuthor(CreateAuthorDTO $DTO): Author
    {
        $author = new Author();
        $author->setFirstName($DTO->getFirstName());
        $author->setLastName($DTO->getLastName());
        $this->entityManager->persist($author);
        $this->entityManager->flush();
        return $author;
    }

    public function deleteAuthor(int $id): void
    {
        $author = $this->entityManager->getRepository(Author::class)->findOneBy(['id' => $id]);
        if ($author === null) {
            throw new NotFoundException();
        }
        $this->entityManager->remove($author);
        $this->entityManager->persist($author);
        $this->entityManager->flush();
    }

    public function deleteAuthorsWithOutBook(): bool
    {
        $authors = $this->entityManager->getRepository(Author::class)->findWithoutBooks();

        if (empty($authors)) {
            return false;
        }

        foreach ($authors as $author) {
            $this->entityManager->remove($author);
        }

        $this->entityManager->flush();
        return true;
    }
}

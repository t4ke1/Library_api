<?php

namespace App\Services;

use App\DTO\BookDTO\CreateBookDTO;
use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Publisher;
use App\Exception\NotFoundException;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;

class BookService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly BookRepository         $BookRepository
    ) {
    }

    public function getBookList(): array
    {
        return $this->BookRepository->getBookList();
    }
    public function deleteBook(int $id): void
    {
        $book = $this->entityManager->getRepository(Book::class)->findOneBy(['id' => $id]);
        if ($book === null) {
            throw new NotFoundException();
        }
        $this->entityManager->remove($book);
        $this->entityManager->flush();
    }
    public function createBook(createBookDTO $DTO): Book
    {

        $publisher = $this->entityManager->getRepository(Publisher::class)->findOneBy(['id' => $DTO->getPublisherId()]);
        if ($publisher === null) {
            throw new NotFoundException();
        }
        $publishDateObject = \DateTime::createFromFormat('Y.m.d', $DTO->getPublishDate());
        $book = new Book();
        $book
            ->setTitle($DTO->getTitle())
            ->setPublishYear($publishDateObject)
            ->setPublisher($publisher);
        foreach ($DTO->getAuthorId() as $author) {
            $authorEntity = $this->entityManager->getRepository(Author::class)->findOneBy(['id' => $author]);
            if ($authorEntity === null) {
                throw new NotFoundException();
            } else {
                $book->addAuthor($authorEntity);
            }
        };
        $this->entityManager->persist($book);
        $this->entityManager->flush();
        return $book;
    }
}

<?php

namespace App\Services;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Publisher;
use App\Exception\asdException;
use App\Exception\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class BookService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function getAllBooks(): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select('b', 'a.lastName AS authorLastName', 'p.name AS publisherName')
            ->from(Book::class, 'b')
            ->leftJoin('b.authors', 'a')
            ->leftJoin('b.publisher', 'p');
        return $queryBuilder->getQuery()->getArrayResult();
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
    public function addBook(string $title, string $publishDate, array $authorId, int $publisherId): Book
    {

        $publisher = $this->entityManager->getRepository(Publisher::class)->findOneBy(['id' => $publisherId]);
        if ($publisher === null) {
            throw new NotFoundException();
        }
        $publishDateObject = \DateTime::createFromFormat('Y.m.d', $publishDate);
        $book = new Book();
        $book
            ->setTitle($title)
            ->setPublishYear($publishDateObject)
            ->setPublisher($publisher);
        foreach ($authorId as $author) {
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

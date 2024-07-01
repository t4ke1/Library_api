<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    private mixed $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function getBookList(): array
    {
        $queryBuilder = $this->createQueryBuilder('b')
            ->select('b', 'a.lastName AS authorLastName', 'p.name AS publisherName')
            ->from(Book::class, 'b')
            ->leftJoin('b.authors', 'a')
            ->leftJoin('b.publisher', 'p');
        return $queryBuilder->getQuery()->getArrayResult();

    }
}

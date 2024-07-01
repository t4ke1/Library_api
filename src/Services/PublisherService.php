<?php

namespace App\Services;

use App\Entity\Book;
use App\Entity\Publisher;
use App\Exception\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class PublisherService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function addPublisher(string $name, string $address): Publisher
    {
        $publisher = new Publisher();
        $publisher
            ->setName($name)
            ->setAddress($address);
        $this->entityManager->persist($publisher);
        $this->entityManager->flush();
        return $publisher;

    }
    public function removePublisher(int $id): void
    {
        $publisher = $this->entityManager->getRepository(Publisher::class)->findOneBy(['id' => $id]);
        if ($publisher === null) {
            throw new NotFoundException();
        }
        $bookRepository = $this->entityManager->getRepository(Book::class)->findAll();
        foreach ($bookRepository as $book) {
            if ($book->getPublisher() === $publisher) {
                $this->entityManager->remove($book);
            }
        }
        $this->entityManager->remove($publisher);
        $this->entityManager->flush();
    }

    public function updatePublisher(string $id, string $name, string $address): Publisher
    {
        $publisher = $this->entityManager->getRepository(Publisher::class)->findOneBy(['id' => $id]);
        if ($publisher === null) {
            throw new NotFoundException();
        }
        $publisher
            ->setName($name)
            ->setAddress($address);
        $this->entityManager->persist($publisher);
        $this->entityManager->flush();
        return $publisher;
    }
}

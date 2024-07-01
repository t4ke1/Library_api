<?php

namespace App\Services;

use App\DTO\PublisherDTO\CreatePublisherDTO;
use App\DTO\PublisherDTO\UpdatePublisherDTO;
use App\Entity\Book;
use App\Entity\Publisher;
use App\Exception\BadRequestException;
use App\Exception\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class PublisherService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function createPublisher(createPublisherDTO $DTO): Publisher
    {
        $publisher = new Publisher();
        $publisher
            ->setName($DTO->getName())
            ->setAddress($DTO->getAddress());
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

    /**
     * @throws BadRequestException
     * @throws NotFoundException
     */
    public function updatePublisher(UpdatePublisherDTO $DTO): Publisher
    {
        $publisher = $this->entityManager->getRepository(Publisher::class)->findOneBy(['id' => $DTO->getId()]);
        if ($publisher === null) {
            throw new NotFoundException();
        }
        if ($DTO->getName() !== null) {
            $publisher->setName($DTO->getName());
        }
        if ($DTO->getAddress() !== null) {
            $publisher->setAddress($DTO->getAddress());
        }
        if (($DTO->getAddress() === null) && ($DTO->getName() === null)) {
            throw new BadRequestException();
        }

        $this->entityManager->persist($publisher);
        $this->entityManager->flush();
        return $publisher;
    }
}

<?php

namespace App\Fixtures;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Publisher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixture extends Fixture
{

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $dataString = "2020-01-$i";
        $dataTimeObject = new \DateTime($dataString);
        $author = new Author();
        $author
            ->setFirstName("AuthorFirstName" . $i)
            ->setLastName("AuthorLastName" . $i);

        $publisher = new Publisher();
        $publisher
            ->setName("PublisherName" . $i)
            ->setAddress("PublisherAddress" . $i);

        $book = new Book();
        $book
            ->setTitle("BookTitle" . $i)
            ->setPublishYear($dataTimeObject)
            ->setPublisher($publisher);

        $book->addAuthor($author);
        $publisher->addBook($book);
        $manager->persist($author);
        $manager->persist($publisher);
        $manager->persist($book);
        }
        $manager->flush();
    }
}
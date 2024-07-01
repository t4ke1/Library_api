<?php

namespace App\Controller;

use App\DTO\AuthorDTO\AddAuthorDTO;
use App\DTO\BookDTO\AddBookDTO;
use App\Exception\NotFoundException;
use App\Services\BookService;
use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    public function __construct(
        private readonly BookService $bookService
    ) {
    }

    #[Route('/api/add-book',name: 'add_book', methods: ['POST'])]
    #[OA\RequestBody(
        description: 'Add book',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(
                properties: [
                    new OA\Property(property: 'title', type: 'string'),
                    new OA\Property(property: 'publishDate', type: 'string', format: 'yyyy.mm.dd', example: '2020.01.01'),
                    new OA\Property(property: 'authorId', type: 'array',
                        items: new OA\Items(type: 'integer',example: [1,2,3])),
                    new OA\Property(property: 'publisherId', type: 'integer',example: 1),
                ],
                type: 'object'
            )
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Success => author added'
    )]
    #[OA\Response(
        response: 409,
        description: 'Data is not valid'
    )]
    public function addBook(AddBookDTO $DTO): JsonResponse
    {
        $title = $DTO->getTitle();
        $publishDate = $DTO->getPublishDate();
        $authorId = $DTO->getAuthorId();
        $publisherId = $DTO->getPublisherId();

        $this->bookService->addBook($title, $publishDate, $authorId, $publisherId);
        return new JsonResponse(['success' => "book added"], 200);
    }

    /**
     * @throws NotFoundException
     */
    #[Route('/api/delete-book/{id}', methods: ['DELETE'])]
    #[OA\Response(
        response: 200,
        description: 'Success => book deleted'
    )]
    #[OA\Response(
        response: 404,
        description: 'Not found'
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'responses',
        in: 'path',
        schema: new OA\Schema(type: 'int')
    )]
    public function deleteBook(Request $request): JsonResponse
    {
        $id = $request->attributes->get('id');
        $this->bookService->deleteBook($id);
        return new JsonResponse(['success' => "book deleted"], 200);
    }
    #[Route('/api/get-all-books', methods: ['GET'])]
    public function getAllBooks(): JsonResponse
    {
       $book = $this->bookService->getAllBooks();
        return new JsonResponse(['success' => $book], 200);
    }
}

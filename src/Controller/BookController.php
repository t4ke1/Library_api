<?php

namespace App\Controller;

use App\DTO\BookDTO\CreateBookDTO;
use App\Exception\NotFoundException;
use App\Services\BookService;
use OpenApi\Attributes as OA;
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

    /**
     * @throws NotFoundException
     */
    #[Route('/api/create-book', name: 'create_book', methods: ['POST'])]
    #[OA\RequestBody(
        description: 'create book',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(
                properties: [
                    new OA\Property(property: 'title', type: 'string'),
                    new OA\Property(property: 'publishDate', type: 'string', format: 'yyyy.mm.dd', example: '2020.01.01'),
                    new OA\Property(
                        property: 'authorId',
                        type: 'array',
                        items: new OA\Items(type: 'integer', example: [1,2,3])
                    ),
                    new OA\Property(property: 'publisherId', type: 'integer', example: 1),
                ],
                type: 'object'
            )
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Success => book has been created'
    )]
    #[OA\Response(
        response: 400,
        description: 'Data is not valid'
    )]
    public function createBook(CreateBookDTO $DTO): JsonResponse
    {
        $this->bookService->createBook($DTO);
        return new JsonResponse(['success' => "book has been created"], 200);
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
    #[Route('/api/book/list', methods: ['GET'])]
    public function getAllBooks(): JsonResponse
    {
        $book = $this->bookService->getBookList();
        return new JsonResponse(['success' => $book], 200);
    }
}

<?php

namespace App\Controller;

use App\DTO\AuthorDTO\CreateAuthorDTO;
use OpenApi\Attributes as OA;
use App\Exception\NotFoundException;
use App\Services\AuthorService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class AuthorController extends AbstractController
{
    public function __construct(
        private readonly AuthorService $authorService
    ) {
    }
    #[Route('/api/create-authors', name: 'create_author', methods: ['POST'])]
    #[OA\RequestBody(
        description: 'Create author',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: CreateAuthorDTO::class))
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Success => author has been created'
    )]
    #[OA\Response(
        response: 400,
        description: 'Data is not valid'
    )]
    #[OA\Parameter(
        name: 'add_author',
        description: 'responses',
        in: 'query',
        schema: new OA\Schema(type: CreateAuthorDTO::class),
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: CreateAuthorDTO::class))
        )
    )]
    public function createAuthor(CreateAuthorDTO $DTO): JsonResponse
    {

        $this->authorService->createAuthor($DTO);
        return new JsonResponse(['success' => "author has been created"], 200);
    }

    /**
     * @throws NotFoundException
     */
    #[Route('/api/delete-author/{id}', name: 'delete_author', methods: ['DELETE'])]
    #[OA\Response(
        response: 200,
        description: 'Success => author deleted'
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
    public function deleteAuthor(Request $request): JsonResponse
    {
        $id = $request->attributes->get('id');
        $this->authorService->deleteAuthor($id);
        return new JsonResponse(['success' => "author deleted"], 200);
    }
}

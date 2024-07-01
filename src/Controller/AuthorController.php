<?php

namespace App\Controller;

use App\DTO\AuthorDTO\AddAuthorDTO;
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
    #[Route('/api/add-authors', name: 'add_author', methods: ['POST'])]
    #[OA\RequestBody(
        description: 'Create author',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: AddAuthorDTO::class))
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
    #[OA\Parameter(
        name: 'add_author',
        description: 'responses',
        in: 'query',
        schema: new OA\Schema(type: AddAuthorDTO::class),
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: AddAuthorDTO::class))
        )
    )]
    public function addAuthor(AddAuthorDTO $DTO): JsonResponse
    {
        $firstname = $DTO->getFirstName();
        $lastname = $DTO->getLastName();

        $this->authorService->addAuthor($firstname, $lastname);
        return new JsonResponse(['success' => "author added"], 200);
    }

    /**
     * @throws NotFoundException
     */
    #[Route('/api/delete-author/{id}',name: 'delete_author', methods: ['DELETE'])]
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

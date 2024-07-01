<?php

namespace App\Controller;

use App\DTO\AuthorDTO\AddAuthorDTO;
use App\DTO\PublisherDTO\AddPublisherDTO;
use App\DTO\PublisherDTO\UpdatePublisherDTO;
use App\Exception\NotFoundException;
use App\Services\PublisherService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

class PublisherController extends AbstractController
{
    public function __construct(
        private readonly PublisherService $publisherService
    ) {
    }

    #[Route('/api/add-publisher', name: 'add_publisher', methods: ['POST'])]
    #[OA\RequestBody(
        description: 'Add publisher',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: AddPublisherDTO::class))
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Success => publisher added'
    )]
    #[OA\Response(
        response: 409,
        description: 'Data is not valid'
    )]
    #[OA\Parameter(
        name: 'add_publisher',
        description: 'responses',
        in: 'query',
        schema: new OA\Schema(type: AddPublisherDTO::class),
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: AddPublisherDTO::class))
        )
    )]
    public function addPublisher(AddPublisherDTO $DTO): JsonResponse
    {
        $name = $DTO->getName();
        $address = $DTO->getAddress();
        $this->publisherService->addPublisher($name, $address);
        return new JsonResponse(['success' => "publisher added"], 200);
    }

    /**
     * @throws NotFoundException
     */

    #[Route('/api/delete-publisher/{id}', methods: ['DELETE'])]
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
    public function deletePublisher(Request $request): JsonResponse
    {
        $id = $request->attributes->get('id');
        $this->publisherService->removePublisher($id);
        return new JsonResponse(['success' => "publisher deleted"], 200);
    }


    /**
     * @throws NotFoundException
     */
    #[Route('/api/update-publisher', name: 'update_publisher', methods: ['PUT'])]
    #[OA\RequestBody(
        description: 'Update publisher',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: UpdatePublisherDTO::class))
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Success => publisher updated'
    )]
    #[OA\Response(
        response: 409,
        description: 'Data is not valid'
    )]
    #[OA\Response(
        response: 404,
        description: 'Not found'
    )]
    #[OA\Parameter(
        name: 'update_publisher',
        description: 'responses',
        in: 'query',
        schema: new OA\Schema(type: UpdatePublisherDTO::class),
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: UpdatePublisherDTO::class))
        )
    )]
    public function updatePublisher(UpdatePublisherDTO $DTO): JsonResponse
    {
        $id = $DTO->getId();
        $name = $DTO->getName();
        $address = $DTO->getAddress();
        $this->publisherService->updatePublisher($id, $name, $address);
        return new JsonResponse(['success' => "publisher updated"], 200);
    }
}

<?php declare(strict_types=1);

namespace Icreative\ContactPersonPlugin\Controller\Api;

use Shopware\Core\Framework\Context;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Icreative\ContactPersonPlugin\Service\ContactPersonService;
use Icreative\ContactPersonPlugin\Service\ValidationException;

#[Route(defaults: ['_routeScope' => ['api']])]
class ContactPersonController extends AbstractController
{
    public function __construct(private readonly ContactPersonService $contactPersonService)
    {
    }

    #[Route(path: '/api/icreative/contact-person', name: 'api.icreative.contact_person.create', methods: ['POST'])]
    public function create(Request $request, Context $context): JsonResponse
    {
        $payload = json_decode((string) $request->getContent(), true);
        if (!is_array($payload)) {
            return new JsonResponse(['errors' => ['body' => ['Invalid JSON']]], 400);
        }

        try {
            $result = $this->contactPersonService->create($payload, $context);
        } catch (ValidationException $e) {
            return new JsonResponse(['errors' => $e->getErrors()], 400);
        }

        return new JsonResponse(['success' => true, 'data' => $result], 201);
    }

    #[Route(path: '/api/icreative/contact-person', name: 'api.icreative.contact_person.list', methods: ['GET'])]
    public function list(Context $context): JsonResponse
    {
        $result = $this->contactPersonService->getRepository()->search(new Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria(), $context);
        $items = [];
        foreach ($result->getEntities() as $entity) {
            $items[] = [
                'id' => $entity->getId(),
                'name' => $entity->getName(),
                'email' => $entity->getEmail(),
                'phone' => $entity->getPhone(),
            ];
        }

        return new JsonResponse(['data' => $items]);
    }
}

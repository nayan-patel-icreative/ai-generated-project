<?php declare(strict_types=1);

namespace Icreative\ContactPersonPlugin\Controller\Api;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route(defaults: ['_routeScope' => ['api']])]
class ContactPersonController extends AbstractController
{
    public function __construct(private readonly EntityRepository $icreativeContactPersonRepository)
    {
    }

    #[Route(path: '/api/icreative/contact-person', name: 'api.icreative.contact_person.create', methods: ['POST'])]
    public function create(Request $request, Context $context): JsonResponse
    {
        $payload = json_decode((string) $request->getContent(), true);
        if (!is_array($payload)) {
            return new JsonResponse(['errors' => ['Invalid JSON']], 400);
        }

        $this->icreativeContactPersonRepository->create([$payload], $context);
        return new JsonResponse(['success' => true]);
    }
}

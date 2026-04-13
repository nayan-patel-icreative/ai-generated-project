<?php declare(strict_types=1);

namespace Icreative\ContactPersonPlugin\Service;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\Uuid\Uuid;

final class ContactPersonService
{
    public function __construct(
        private readonly EntityRepository $icreativeContactPersonRepository,
        private readonly ContactPersonValidator $validator,
    ) {
    }

    /** @return array{id: string} */
    public function create(array $payload, Context $context): array
    {
        $errors = $this->validator->validate($payload);
        if ($errors !== []) {
            throw new ValidationException($errors);
        }

        $id = $payload['id'] ?? null;
        if (!is_string($id) || !Uuid::isValid($id)) {
            $id = Uuid::randomHex();
        }

        $data = [
            'id' => $id,
            'name' => (string) $payload['name'],
            'email' => (string) $payload['email'],
            'phone' => isset($payload['phone']) ? (string) $payload['phone'] : null,
        ];

        $this->icreativeContactPersonRepository->create([$data], $context);

        return ['id' => $id];
    }

    public function getRepository(): EntityRepository
    {
        return $this->icreativeContactPersonRepository;
    }
}

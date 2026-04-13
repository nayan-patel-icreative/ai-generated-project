<?php declare(strict_types=1);

namespace Icreative\ContactPersonPlugin\Service;

final class ContactPersonValidator
{
    /** @return array<string, list<string>> */
    public function validate(array $payload): array
    {
        $errors = [];

        $name = $payload['name'] ?? null;
        if (!is_string($name) || trim($name) === '') {
            $errors['name'][] = 'Name is required.';
        }

        $email = $payload['email'] ?? null;
        if (!is_string($email) || trim($email) === '') {
            $errors['email'][] = 'Email is required.';
        } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $errors['email'][] = 'Email must be a valid email address.';
        }

        $phone = $payload['phone'] ?? null;
        if ($phone !== null && !is_string($phone)) {
            $errors['phone'][] = 'Phone must be a string.';
        }

        return $errors;
    }
}

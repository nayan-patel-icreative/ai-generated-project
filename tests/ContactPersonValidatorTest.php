<?php declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Icreative\ContactPersonPlugin\Service\ContactPersonValidator;

final class ContactPersonValidatorTest extends TestCase
{
    public function testValidPayloadHasNoErrors(): void
    {
        $validator = new ContactPersonValidator();

        $errors = $validator->validate([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '123',
        ]);

        static::assertSame([], $errors);
    }

    public function testMissingRequiredFieldsReturnsErrors(): void
    {
        $validator = new ContactPersonValidator();

        $errors = $validator->validate([]);

        static::assertArrayHasKey('name', $errors);
        static::assertArrayHasKey('email', $errors);
    }

    public function testInvalidEmailReturnsError(): void
    {
        $validator = new ContactPersonValidator();

        $errors = $validator->validate([
            'name' => 'John Doe',
            'email' => 'not-an-email',
        ]);

        static::assertArrayHasKey('email', $errors);
    }
}

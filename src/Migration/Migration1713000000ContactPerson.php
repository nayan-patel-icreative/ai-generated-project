<?php declare(strict_types=1);

namespace Icreative\ContactPersonPlugin\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1713000000ContactPerson extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1713000000;
    }

    public function update(Connection $connection): void
    {
        $connection->executeStatement(
            'CREATE TABLE IF NOT EXISTS icreative_contact_person (' .
            'id BINARY(16) NOT NULL,' .
            'name VARCHAR(255) NOT NULL,' .
            'email VARCHAR(255) NOT NULL,' .
            'phone VARCHAR(255) NULL,' .
            'created_at DATETIME(3) NOT NULL,' .
            'updated_at DATETIME(3) NULL,' .
            'PRIMARY KEY (id)' .
            ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;'
        );
    }

    public function updateDestructive(Connection $connection): void
    {
    }
}

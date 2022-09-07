<?php declare(strict_types=1);
/*
 * Copyright (C) 2021 E-Comprocessing Ltd.
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * @author      E-Comprocessing
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU General Public License, version 2 (GPL-2.0)
 */

namespace Ecomprocessing\Genesis\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1648646440TokenizationConsumer extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1648646440;
    }

    public function update(Connection $connection): void
    {
        $query = <<<SQL
    CREATE TABLE IF NOT EXISTS ecomprocessing_tokenization_consumer (
        id           BINARY(16)    NOT NULL,
        email        VARCHAR (320) NOT NULL,
        consumer_id  VARCHAR (64)  NOT NULL,
        created_at   DATETIME(3)   NOT NULL,
        updated_at   DATETIME(3)   NULL,
        PRIMARY KEY  (id),
        UNIQUE INDEX idx_email (email)
    )
    ENGINE=InnoDB
    DEFAULT CHARSET=utf8mb4
    COLLATE=utf8mb4_general_ci;
SQL;
        $connection->executeUpdate($query);
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}

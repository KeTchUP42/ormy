<?php
declare(strict_types = 1);

namespace ORMY\Migrations;

use ORMY\Migrator\Migrations\AbstractMigration;

/**
 * template of migration class
 */
class Migration extends AbstractMigration
{
    /**
     * method makes sql query
     */
    public function up(): void
    {
        $this->connector->exec('');
    }

    /**
     * method makes sql query
     */
    public function down(): void
    {
        $this->connector->exec('');
    }
}

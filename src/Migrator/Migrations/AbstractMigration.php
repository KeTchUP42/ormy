<?php
declare(strict_types = 1);

namespace ORMY\Migrator\Migrations;

use ORMY\Traits\ConnectorTrait;

/**
 * AbstractMigration
 */
abstract class AbstractMigration
{
    use ConnectorTrait;

    /**
     * Method applies all DB changes.
     */
    abstract public function up(): void;

    /**
     * Method rolls back DB changes.
     */
    abstract public function down(): void;
}

<?php
declare(strict_types = 1);

namespace ORMY\Migrator\Migrations;

use ORMY\Traits\ConnectorTrait;

/**
 *  AbstractMigration
 */
abstract class AbstractMigration
{
    use ConnectorTrait;

    /**
     * Method applys all db changes
     */
    abstract public function up(): void;

    /**
     * Method roll back all db changes
     */
    abstract public function down(): void;
}

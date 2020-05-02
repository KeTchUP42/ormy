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
}

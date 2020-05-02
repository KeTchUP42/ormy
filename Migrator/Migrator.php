<?php
declare(strict_types = 1);

namespace ORMY\Migrator;

use ORMY\Migrator\source\AbstractMigrator;

/**
 * ORM Migrator
 */
class Migrator extends AbstractMigrator
{
    /**
     * @param string $sqlQueryUp
     * @param string $sqlQueryDown
     *
     * @return bool
     */
    public function makeMigration(string $sqlQueryUp, string $sqlQueryDown = ''): bool
    {
        //todo !
        return false;
    }

    /**
     *
     * @return bool
     */
    public function migrateUp(): bool
    {
        // TODO: Implement migrateUp() method.
        return false;
    }

    /**
     *
     * @return bool
     */
    public function migrateDown(): bool
    {
        // TODO: Implement migrateDown() method.
        return false;
    }
}

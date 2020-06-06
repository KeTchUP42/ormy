<?php
declare(strict_types = 1);

namespace ORMY\Migrator;

use ORMY\Exceptions\FileNotFoundException;

/**
 *
 */
interface IMigrator
{
    /**
     * Method creates new migration and puts it to the migration's dir.
     *
     * @param string $sqlQueryUp
     * @param string $sqlQueryDown
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function makeMigration(string $sqlQueryUp, string $sqlQueryDown = ''): void;

    /**
     * Method calls `up` method in new migrations and updates version table.
     *
     * @return bool
     */
    public function migrateUp(): bool;

    /**
     * Method calls `down` method in migrations and deletes all executed versions from db
     *
     * @return bool
     */
    public function migrateDown(): bool;
}

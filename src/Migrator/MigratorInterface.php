<?php
declare(strict_types = 1);

namespace ORMY\Migrator;

use ORMY\Exceptions\FileNotFoundException;

/**
 * MigratorInterface
 */
interface MigratorInterface
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
     * @return void
     */
    public function migrateUp(): void;

    /**
     * Method calls `down` method in migrations and deletes all executed versions from db
     *
     * @return void
     */
    public function migrateDown(): void;
}

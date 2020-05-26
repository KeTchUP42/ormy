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
     * Method makes migration ->
     * adds new migration class
     *
     * @param string $sqlQueryUp
     * @param string $sqlQueryDown
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function makeMigration(string $sqlQueryUp, string $sqlQueryDown = ''): void;

    /**
     * Method calls up methods in new migrations
     * and writes to db new executed version
     *
     * @return bool
     */
    public function migrateUp(): bool;

    /**
     * Method calls all down methods in migrations
     * and deletes all executed versions from db
     *
     * @return bool
     */
    public function migrateDown(): bool;
}

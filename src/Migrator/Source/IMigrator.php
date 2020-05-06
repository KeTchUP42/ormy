<?php
declare(strict_types = 1);

namespace ORMY\Migrator\Source;

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
     * Method migrates up
     * writes to db new executed version
     *
     * @return bool
     */
    public function migrateUp(): bool;

    /**
     * Method migrates down
     * deletes all executed versions from db
     *
     * @return bool
     */
    public function migrateDown(): bool;
}

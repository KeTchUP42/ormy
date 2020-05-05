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
     * method maker migration
     * writes to db new ver
     * add new migration class
     *
     * @param string $sqlQueryUp
     * @param string $sqlQueryDown
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function makeMigration(string $sqlQueryUp, string $sqlQueryDown = ''): void;

    /**
     * method migrateUp
     *
     * @return bool
     */
    public function migrateUp(): bool;

    /**
     * method migrateDown
     *
     * @return bool
     */
    public function migrateDown(): bool;
}

<?php
declare(strict_types = 1);

namespace ORMY\Migrator\source;

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
     * @return bool
     */
    public function makeMigration(string $sqlQueryUp, string $sqlQueryDown = ''): bool;

    /**
     * method migrateUp
     *
     * @return bool
     */
    public function migrateUp(): bool;

    /**
     * method  migrateDown
     *
     * @return bool
     */
    public function migrateDown(): bool;
}
